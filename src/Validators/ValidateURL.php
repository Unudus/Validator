<?php
namespace Unudus\Validator\Validators;

/**
 *A Validation Class for URL strings.
 * @author Kyle Truswell
 *        
 */
class ValidateURL extends BaseValidate
{
    const TYPE_LABEL = "URL Validator";
    
    const EXCEPTION_FAILS_RFC   = "Value did not pass the server's URL standards check. See RFC 2396 for rules followed";
    const EXCEPTION_FAILS_REGEX = "Value did not pass a usable URL pattern match.";
    
    // note : no URL regex is perfect, but as FILTER_VALIDATE_URL won't handle things like extensions, this will atleast help filter out "valid" but in practice incorrect urls.
    // e.g. "google" shouldn't work by itself
    const REGEX_PATTERN = "/[-a-zA-Z0-9@:%_\+.~#?&\/\/=]{2,256}\.[a-z]{2,9}\b(\/[-a-zA-Z0-9@:%_\+.~#?&\/\/=]*)?/i";
    
    /**
     *Create a URL validator
     * @param $strURL string the value to validate as a URL
     * @param $blnAutoAddProtocol bool (optional) If "http://" should be automatically prepended when it's missing. Defaults to true
     */
    public function __construct( $strURL, $blnAutoAddProtocol = true )
    {
        if ( $blnAutoAddProtocol && stripos( $strURL, 'http://' ) !== 0 )
        {
            echo "correcting ".$strURL." to http://".$strURL.'<br />';
            $strURL = "http://".$strURL;
        }
        parent::__construct( $strURL );
    }

    /**
     * Validates if the value set is a valid URL
     *  
     * @return bool Returns true if the value is a valid URL, otherwise returns false.
     */
    public function validate():bool
    {
        $blnReturn = true;
        if ( !$this->isValueString() )
        {
            $this->arrExceptions[] = static::EXCEPTION_INCORRECT_INPUT_TYPE;
            $blnReturn = false;
        }
        else
        {
            if ( filter_var( $this->mxdValue, FILTER_VALIDATE_URL, FILTER_FLAG_HOST_REQUIRED ) === false )
            {
                $this->arrExceptions[] = static::EXCEPTION_FAILS_RFC;
                $blnReturn = false;
            }
            
            if ( preg_match( static::REGEX_PATTERN, $this->mxdValue ) == 0 )
            {
                $this->arrExceptions[] = static::EXCEPTION_FAILS_REGEX;
                $blnReturn = false;
            }
        }
        return $blnReturn;
    }
}

