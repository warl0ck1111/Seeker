-- where preference is Female
select* from users where user_id != (select user_id from users where u_name = $_SESSION['name']['u_name']) and preference = 'f';

-- where preference is Male
select* from users where user_id != (select user_id from users where u_name = $_SESSION['name']['u_name']) and preference = 'm';

-- where preference is Both Male & Female
select* from users where user_id != (select user_id from users where u_name = $_SESSION['name']['u_name']) and preference = 'm';


-- where preference is Both Age is Range $FRM $TO
select* from users where user_id != (select user_id from users where u_name = $_SESSION['name']['u_name']) and preference = 'm';


 