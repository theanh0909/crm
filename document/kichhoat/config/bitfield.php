<?php

class bitmask {

    public $permissions = array(
        "editregistered" => false,
        "deleteregistered" => false,
        "writeemail" => false,
        "viewregistered" => false,
        "viewallregistered" => false,
        "editemail" => false,
        "adduser" => false,
        "edituser" => false,
        "deleteuser" => false,
        "manageruser" => false,
        "viewuser" => false,
        "addgroup" => false,
        "editgroup" => false,
        "key" => false,
        "addkey" => false,
        "changcekey" => false,       
        "viewkey" => false,
        "viewdutoan" => false,
        "viewduthau" => false,
        "viewtqt" => false,
        "viewproduct" => false,
        "addproduct" => false,
        "editproduct" => false,
        "deleteproduct" => false,
        "changekey" => false,
        "expire_1" => false,
        "expire" => false,
		"sendkey" => false,
		"keydungthu" => false,
    );

    public function getPermissions($bitMask = 0) {
        $i = 0;
        foreach ($this->permissions as $key => $value) {
            $this->permissions[$key] = (($bitMask & pow(2, $i)) != 0) ? true : false;
            //uncomment the next line if you would like to see what is happening.
            //echo $key . " i= ".strval($i)." power=" . strval(pow(2,$i)). "bitwise & = " . strval($bitMask & pow(2,$i))."<br>";
            $i++;
        }
        return $this->permissions;
    }

    function toBitmask() {
        $bitmask = 0;
        $i = 0;
        foreach ($this->permissions as $key => $value) {

            if ($value) {
                $bitmask += pow(2, $i);
            }
            $i++;
        }
        return $bitmask;
    }

}

?>
