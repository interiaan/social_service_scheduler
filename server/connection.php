<?php

$conn = new mysqli("localhost", "root", "", "social_service_schedule");
if ($conn->connect_error) {
    throw new Exception("Database Connection Unestablished");
}