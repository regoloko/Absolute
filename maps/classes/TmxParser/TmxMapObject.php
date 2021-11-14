<?php
  namespace TmxParser;

  class TmxMapObject extends Parser
  {
    public $id;
    public $name;
    public $x;
    public $y;
    public $width;
    public $height;
    public $properties;

    public function __construct
    (
      $Map_Object
    )
    {
      $this->GetTiledObjectFromXmlElement($Map_Object, $this);

      if ( !empty($Map_Object->properties) )
      {
        foreach ($Map_Object->properties->property as $Current_Property)
        {
          $Property = new TmxProperty;
          $this->GetTiledObjectFromXmlElement($Current_Property, $Property);
          $this->properties[$Property->name] = $Property->value;

          if ( !$this->HasProperty($Property->name) )
          {
            $this->properties[$Property->name] = $Current_Property;
          }
        }

        unset($Current_Property);
      }
    }

    /**
     * Check if the object has a given property.
     *
     * @param {string} $Property_Name
     */
    public function HasProperty
    (
      string $Property_Name
    )
    {
      foreach ( $this->properties as $Property )
        if ( $Property->name == $Property_Name )
          return true;

      return false;
    }
  }