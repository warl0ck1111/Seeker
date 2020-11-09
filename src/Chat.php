<?php

namespace MyApp;

use DateTime;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

require "../db/Users.php";
require "../db/chatrooms.php";
 




class Chat implements MessageComponentInterface
{
    protected $clients;
    private $UserConn;

    public function __construct()
    {
        $this->clients = new \SplObjectStorage;
        echo "server Started...\n";
    }

    public function onOpen(ConnectionInterface $conn)
    {
        // Store the new connection to send messages to later
        $this->clients->attach($conn);

        echo "New connection! ({$conn->resourceId})\n";
    }

    public function onMessage(ConnectionInterface $from, $msg)
    {
        $numRecv = count($this->clients) - 1;
        echo sprintf(
            'Connection %d sending message "%s" to %d other connection%s' . "\n",
            $from->resourceId,
            $msg,
            $numRecv,
            $numRecv == 1 ? '' : 's'
        );
        $data = json_decode($msg, true);
        
        $col = [$data['sId']] = $from->resourceId;
         


        $objChat = new \Chatrooms();
        $objChat->setUserId($data['sId']);
        $objChat->setMsg($data['msg']);

        $objChat->setSenderId($data['sId']);
        $objChat->setReceiverId($data['rId']);
        $objChat->setCreated_on(date('Y-m-d H:i:s'));
        if ($objChat->saveMsg()) {

            echo "msg saved...\n";
            

             
        } else {
            echo "there was aproblem saving msg...\n";
        }

        foreach ($this->clients as $client) {
            if ($from !== $client) {
                // The sender is not the receiver, send to each client connected
                $client->send($msg);
            }
        }
    }

    public function onClose(ConnectionInterface $conn)
    {
        // The connection is closed, remove it, as we can no longer send it messages
        $this->clients->detach($conn);

        echo "Connection {$conn->resourceId} has disconnected\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e)
    {
        echo "An error has occurred: {$e->getMessage()}\n";

        $conn->close();
    }
}
