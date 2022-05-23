<?php

class SurveyFileStorage
{
    private const FOLDER_DATA = './data/';
    private const FILE_EMAIL = 'Email';
    private const FILE_FIRST_NAME = 'Ваше имя';
    private const FILE_ACTIVITY = 'Деятельность';    
    private const FILE_AGREEMENT = 'Согласие на рассылку';
    private const DELIMETER_PARAMETERS = ': ';

    private static function createFileName(?string $email): string
    {
        return self::FOLDER_DATA . $email . '.txt';
    }

    // public static function loadSurveyFromFile(?string $email): ?Survey
    // {
    //     $fileName = self::createFileName($email);
    //     if ((!$email || $email !== '') && file_exists($fileName))
    //     {
    //         $tempArray = file($fileName);
    //         $arrayData = [];
    //         foreach ($tempArray as $line)
    //         {
    //             $tempString = explode(self::DELIMETER_PARAMETERS, $line);
    //             $arrayData[$tempString[0]] = trim($tempString[1]) ?? null;
    //         }
    //         return new Survey(
    //             $arrayData[self::FILE_EMAIL], 
    //             $arrayData[self::FILE_FIRST_NAME], 
    //             $arrayData[self::FILE_ACTIVITY], 
    //             $arrayData[self::FILE_AGREEMENT]
    //         );
    //     }  

    //     echo PHP_EOL . 'Impossible email (for load Survey from file)' . PHP_EOL . PHP_EOL;
    //     return null;         
    // }

    public static function saveSurveyToFile(Survey $survey): array
    {        
        if ($survey === null)
        {
            return ['status' => 400, 'message' => 'Empty email'];
        }
        if (!file_exists(self::FOLDER_DATA))
        {
            mkdir(self::FOLDER_DATA);
        }
        if (!is_writable(self::FOLDER_DATA))
		{ 
			return ['status' => 500, 'message' => 'Access denied'];
		}

        $fileName = self::createFileName($survey->getEmail());

        $tempEmail = self::FILE_EMAIL . self::DELIMETER_PARAMETERS;
        $tempFirstName = self::FILE_FIRST_NAME . self::DELIMETER_PARAMETERS;
        $tempActivity = self::FILE_ACTIVITY . self::DELIMETER_PARAMETERS;        
        $tempAgreement = self::FILE_AGREEMENT . self::DELIMETER_PARAMETERS;

        if (file_exists($fileName))
        {
            $tempArray = file($fileName);
            if ($survey->getFirstName() !== null)
            {
                $tempArray[0] = $tempFirstName . $survey->getFirstName() . PHP_EOL;
            }
            if ($survey->getActivity() !== null)
            {
                $tempArray[2] = $tempActivity . $survey->getActivity() . PHP_EOL;
            }
            if ($survey->getAgreement() !== null)
            {
                $tempArray[3] = $tempAgreement . $survey->getAgreement();
            }
            file_put_contents($fileName, $tempArray);
            return ['status' => 200, 'message' => 'Update file'];
        }
        else
        {
            $surveyTxt = fopen($fileName, "w");
            fwrite($surveyTxt, $tempFirstName . $survey->getFirstName() . PHP_EOL);
            fwrite($surveyTxt, $tempEmail . $survey->getEmail() . PHP_EOL);            
            fwrite($surveyTxt, $tempActivity . $survey->getActivity() . PHP_EOL);            
            fwrite($surveyTxt, $tempAgreement . $survey->getAgreement());
            fclose($surveyTxt);
            return ['status' => 200, 'message' => 'Create file'];
        }
    }   
}