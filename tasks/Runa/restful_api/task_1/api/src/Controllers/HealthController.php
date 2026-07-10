<?php
namespace Controllers;

use Http\Response;

class HealthController {
    public function check(): void {
        Response::json(["status" => "ok"]);
    }
}