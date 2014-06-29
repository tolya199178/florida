<?php
class ImportRestaurantCertificateForm extends CFormModel
{
    public $csvFile;
    
    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return array(  
//            array('csvFile', 'required'),
            array('csvFile', 'file', 'types'=>'csv'),
        );
    }
    
    
}