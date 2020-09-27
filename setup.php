<?php require('config.php');

createTable("users","`user_id` int(11) NOT NULL AUTO_INCREMENT,
`f_name` varchar(255) NOT NULL,
`l_name` varchar(255) NOT NULL,
`u_name` varchar(20) NOT NULL,
`phone` varchar(15) NOT NULL,
`email` varchar(30) NOT NULL,
`pwd` varchar(255) NOT NULL,
`state` varchar(255) DEFAULT NULL,
`lga` varchar(255) DEFAULT NULL,
`preference` enum('m','f','mf') DEFAULT 'mf',
`gender` enum('m','f') DEFAULT NULL,
`profile_image` varchar(255) DEFAULT NULL,
`bio` varchar(1000) DEFAULT NULL,
`forgot_pwd_code` varchar(255) DEFAULT NULL,
`created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
`hobbies_id` int(11) DEFAULT NULL,
`age` int(3) DEFAULT NULL,
`role` enum('seeker','admin') DEFAULT NULL,
`suspended` enum('true','false') DEFAULT 'false',
PRIMARY KEY (`user_id`),
UNIQUE KEY `u_name` (`u_name`),
UNIQUE KEY `phone` (`phone`),
UNIQUE KEY `email` (`email`),
UNIQUE KEY `phone_2` (`phone`)
) ENGINE=InnoDB AUTO_INCREMENT=157 DEFAULT CHARSET=latin1)");

createTable('likes',"`like_id` int(11) NOT NULL AUTO_INCREMENT,
`user_id` int(11) DEFAULT NULL,
`liked_id` int(11) DEFAULT NULL,
`timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
PRIMARY KEY (`like_id`),
KEY `user_id` (`user_id`),
KEY `liked_id` (`liked_id`),
CONSTRAINT `likes_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
CONSTRAINT `likes_ibfk_2` FOREIGN KEY (`liked_id`) REFERENCES `users` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=236 DEFAULT CHARSET=latin1");

createTable("unlikes", "`id` int(11) NOT NULL AUTO_INCREMENT,
`user_id` int(11) DEFAULT NULL,
`unliked_uid` int(11) DEFAULT NULL,
`timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=77 DEFAULT CHARSET=utf8mb4");

createTable("matches","`match_id` int(11) NOT NULL AUTO_INCREMENT,
`user_id` int(11) DEFAULT NULL,
`matched_id` int(11) DEFAULT NULL,
`timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
PRIMARY KEY (`match_id`),
KEY `user_id` (`user_id`),
KEY `matched_id` (`matched_id`),
CONSTRAINT `matches_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
CONSTRAINT `matches_ibfk_2` FOREIGN KEY (`matched_id`) REFERENCES `users` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1");

createTable("reportedusers","`reportID` int(11) NOT NULL AUTO_INCREMENT,
`reported_user_id` int(11) DEFAULT NULL,
`reporter_id` int(11) NOT NULL,
`reason` varchar(1000) DEFAULT NULL,
`timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
`u_name` varchar(255) DEFAULT NULL,
`rptr_u_name` varchar(255) DEFAULT NULL,
PRIMARY KEY (`reportID`),
KEY `tinderID` (`reported_user_id`),
CONSTRAINT `reportedusers_ibfk_1` FOREIGN KEY (`reported_user_id`) REFERENCES `users` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4");


createTable("messages"," `message_id` int(11) NOT NULL AUTO_INCREMENT,
`match_id` int(11) NOT NULL,
`messageString` varchar(1000) DEFAULT NULL,
`sender` int(11) DEFAULT NULL,
`receiver` int(11) DEFAULT NULL,
`timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
PRIMARY KEY (`message_id`),
KEY `fkreciver` (`receiver`),
KEY `fksender` (`sender`),
CONSTRAINT `fksender` FOREIGN KEY (`sender`) REFERENCES `users` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
?>