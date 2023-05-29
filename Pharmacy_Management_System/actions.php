<?php 
	session_start();
	require_once('db.php');

    Class Actions extends db{
        function save_log($data=array())
        {
            if(count($data)>0){
                extract($data);
                $sql = "INSERT INTO 'logs' ('id', 'action') 
                VALUES ('{$user_id}','{$action_made}')";

                $save = $this->conn->query($sql);
                if (!$save){
                    die($sql."<br>ERROR:" .$this->conn->error);
                }
            }
            return true;
        }

        //add this part to the login section
        $log['user'] = $_SESSION['id'];
        $log['action_made'] = "Logged in the system";
        $this->save_log($log)
    }

