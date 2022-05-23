<?php
require_once("./src/common.inc.php");

$requestSurveyLoader = new RequestSurveyLoader();
$surveyFileStorage = new SurveyFileStorage();

$survey = $requestSurveyLoader->createSurveyInfo();
echo json_encode($surveyFileStorage->saveSurveyToFile($survey));