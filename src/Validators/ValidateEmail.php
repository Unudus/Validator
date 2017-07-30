<?php
namespace Unudus\Validator\Validators;

/**
 * A Validation Class for email addresses.
 * Primary validation uses filter_var() but will also feedback if;
 *      value isn't a string
 *      value is too short
 *      value lacks the @ delimitor between local-part and domain
 * @author Kyle Truswell
 *        
 */
class ValidateEmail extends BaseValidate
{
    const TYPE_LABEL = "Email Validator";
    
    // Note : I've included 2 examples of meaningful exception throws, but there are many more which could be included ( local & domain checks, running checkdnsrr to check if the provided domain exists etc ).
    // because the !filter_var( $strEmail, FILTER_VALIDATE_EMAIL ) does all the main validation, omitting these just means less descriptive exceptions, and shouldn't impact the strength of the validation
    const EXCEPTION_TOO_SHORT   = "ValuepPassed too short. Email addresses need to be at least 5 characters long";
    const EXCEPTION_NO_AT       = "Value lacks a @ delimiter. The @ symbol is required between the local-part and the domain";
    const EXCEPTION_FAILS_RFC   = "Value passed did not pass the server's email standards check. See RFC 822 for rules followed";
    
    /**
     * Create a new Email validator.
     * @param $strEmail The value you wish to validate as an email. Should be a string
     */
    public function __construct( $strEmail )
    {
        // Note : while the base class's contructor would be fine, by overriding like this the caller gets a more descriptive PHPDoc comment & a parameter more in line with expected data
        $this->mxdValue = $strEmail;
    }

    /**
     * Validates if the value is plausably an email address
     *  
     * @return bool Returns true if the value could be an email, otherwise returns false.
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
            // note: strlen() does have issues with some international encodings, but shouldn't be an issue with UTF-8
            // The length of 5 is based on a@b.c being potentially valid email
            if ( strlen( $this->mxdValue ) < 5 )
            {
                $this->arrExceptions[] = static::EXCEPTION_TOO_SHORT;
                $blnReturn = false;
            }
            
            if ( stripos( $this->mxdValue, '@') === false )
            {
                $this->arrExceptions[] = static::EXCEPTION_NO_AT;
                $blnReturn = false;
            }
            
            if ( !filter_var( $this->mxdValue, FILTER_VALIDATE_EMAIL ) )
            {
                $this->arrExceptions[] = static::EXCEPTION_FAILS_RFC;
                $blnReturn = false;
            }
        }
        return $blnReturn;
    }
}