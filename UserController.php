<?php

// UserController.php

class UserController
{
    public function show($id)
    {
        echo "Kullanıcı ID'si: " . $id;
    }

    public function store()
    {
        echo "Yeni kullanıcı kaydedildi.";
    }
}
