<?php

class RequestSurveyLoader
{
    private const POST_EMAIL = "email";
    private const POST_FIRST_NAME = "first_name";
    private const POST_ACTIVITY = "activity";    
    private const POST_AGREEMENT = "agreement";

    public function createSurveyInfo(): ?Survey
    {
        $inputJSON = file_get_contents('php://input');
        $input = json_decode($inputJSON, true);

        if (!$input[self::POST_EMAIL]) 
        {
            return null;
        }
        $email = $input[self::POST_EMAIL];
        $firstName = $input[self::POST_FIRST_NAME] ?? null;
        $activity = $input[self::POST_ACTIVITY] ?? null;   
        $agreement = $input[self::POST_AGREEMENT] ?? null;

        return new Survey($email, $firstName, $activity, $agreement);
    }
}