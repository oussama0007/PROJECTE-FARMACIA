<?php

if (!isset($_SESSION["users"])) {

    $_SESSION["users"] = [
        [
            "id" => 1,
            "name" => "Admin",
            "username" => "admin",
            "email" => "admin@farmacia.com",
            "password" => password_hash("admin123", PASSWORD_DEFAULT),
            "role" => "admin",
            "profile_image" => "default.png"
        ]
    ];
}