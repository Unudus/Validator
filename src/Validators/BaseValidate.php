<?php
namespace Unudus\Validator\Validators;


/**
 * A base class for all Validation classes to extend.
 * 
 * Note : I've opted to log "Exceptions" inside instances, instead of throwing Exceptions
 * during validation. The intent to avoid causing issues on different configurations,
 * make the validation safe to use inside a conditional statement and still provide
 * verbose exception information should the user want/need it. 
 * 
 * @author Kyle Truswell
 *        
 */
abstract class BaseValidate
{
    const TYPE_LABEL = "Base Validator"; // should only be seen if a child class doesn't override it
    
    protected $mxdValue;
    protected $arrExceptions = [];

    // All validators will need to handle this exception type
    // note : I'm using labels instead of simple numbers here just to make
    // the test output code cleaner.
    const EXCEPTION_INCORRECT_INPUT_TYPE = "Bad Value Passed"; // an exception that all validators will have to handle
    
    public function __construct( $mxdValue )
    {
        $this->mxdValue = $mxdValue;
    }

    public function setValue( $mxdValue )
    {
        $this->mxdValue = $mxdValue;
    }
    
    public function getExceptions()
    {
        // Just a simpler getter for now.
        return $this->arrExceptions;
    }
    
    abstract public function validate():bool;
    
    // note : These just help keep the actual validate() implementations clear and easy to read
    protected function isValueString():bool
    {
        return ( isset( $this->mxdValue ) && is_string( $this->mxdValue ) );
    }
    
    protected function isValueNumber():bool
    {
        return ( isset( $this->mxdValue ) && is_numeric( $this->mxdValue ) );
    }
}