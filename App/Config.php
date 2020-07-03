<?php

namespace App;

/**
 * Application configuration
 *
 * PHP version 7.0
 */
class Config
{

    /**
     * Database host
     * @var string
     */
    const DB_HOST = 'localhost';

    /**
     * Database name
     * @var string
     */
    const DB_NAME = 'happybox';

    /**
     * Database user
     * @var string
     */
    const DB_USER = 'root';

    /**
     * Database password
     * @var string
     */
    const DB_PASSWORD = '';
    /**
     * telegram bot token
     * @var string
     */
    const BOT_TOKEN = "848616276:AAFyQ-o8hnCy1bAyrsGzanN01eb8eX8TGTk";
    /**
     * telegram chat_id 
     * @var string
     */
    const CHAT_ID = "-423670779";
     /**
     * recaptcha site key 
     * @var string
     */
    const SITE_KEY = "6Lcgh_oUAAAAAIPl1cgjobXZD1FJwjzY2ag_AIKk";
     /**
     * recaptcha secret key 
     * @var string
     */
    const SECRET_KEY = "6Lcgh_oUAAAAAKQooBJsU0V0w7FXR5SIj3WT4pCH";

    /**
     * Show or hide error messages on screen
     * @var boolean
     */
    const SHOW_ERRORS = true;

    /**
     * enable or disable production mode
     * @var boolean
     */
    const ENABLE_PRODUCTION = false;
}
