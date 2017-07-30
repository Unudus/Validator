<?php
namespace Unudus\Validator\Validators;

/**
 *
 * @author Kyle Truswell
 *        
 */
class ValidateEmail extends BaseValidate
{
    const EXCEPTION_TOO_SHORT = "Email addresses need to be at least 5 characters long";
    
    /**
     */
    public function __construct( $strEmail )
    {
        $this->mxdValue = $strEmail;
    }

    /**
     * 
     *
     *
     */
    public function validate():bool
    {
        if ( true )
        {
            $this->arrExceptions[] = static::EXCEPTION_INCORRECT_INPUT_TYPE;
            $this->arrExceptions[] = static::EXCEPTION_TOO_SHORT;
            return false;
        }
        return true;
    }
}