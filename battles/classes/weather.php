<?php
  class Weather
  {
    public $Name = null;
    public $Turns_Left = null;
    public $Dialogue = null;

    public function __construct
    (
      string $Weather_Name
    )
    {
      $Weather_Data = $this->WeatherList()[$Weather_Name];
      if ( !isset($Weather_Data) )
        return false;

      $this->Name = $Weather_Name;
      $this->Turns_Left = 5;
      $this->Dialogue = $Weather_Data['Text'];
    }

    /**
     * Decrement how many turns remain.
     */
    public function TickWeather()
    {
      if ( $this->Turns_Left > 0 )
        $this->Turns_Left--;

      return $this;
    }

    /**
     * End the current weather.
     */
    public function EndWeather()
    {
      switch ($this->Name)
      {
        case 'Clear Skies':
          return [
            'Text' => ''
          ];

        case 'Fog':
          return [
            'Text' => 'The fog has been blown away!<br />',
          ];

        case 'Hail':
          return [
            'Text' => 'The hail stopped.<br />'
          ];

        case 'Rain':
          return [
            'Text' => 'The rain stopped.<br />'
          ];

        case 'Heavy Rain':
          return [
            'Text' => 'The heavy rain has lifted!<br />'
          ];

        case 'Sandstorm':
          return [
            'Text' => 'The sandstorm subsided.<br />'
          ];

        case 'Harsh Sunlight':
          return [
            'Text' => 'The harsh sunlight faded.<br />'
          ];

        case 'Extremely Harsh Sunlight':
          return [
            'Text' => 'The harsh sunlight faded.<br />'
          ];

        case 'Shadowy Aura':
          return [
            'Text' => 'The shadowy aura faded away!<br />'
          ];

        case 'Strong Wings':
          return [
            'Text' => 'The mysterious strong winds have dissipated!<br />'
          ];
      }
    }

    /**
     * All possible field effects.
     */
    public function WeatherList()
    {
      return [
        'Clear Skies' => [
          'Text' => ''
        ],
        'Fog' => [
          'Text' => 'The fog is deep...',
        ],
        'Hail' => [
          'Text' => 'It started to hail!'
        ],
        'Rain' => [
          'Text' => 'It started to rain!'
        ],
        'Heavy Rain' => [
          'Text' => 'A heavy rain begain to fall!'
        ],
        'Sandstorm' => [
          'Text' => 'A sandstorm kicked up!'
        ],
        'Harsh Sunlight' => [
          'Text' => 'The sunlight turned harsh!'
        ],
        'Extremely Harsh Sunlight' => [
          'Text' => 'The sunlight turned extremely harsh!'
        ],
        'Shadowy Aura' => [
          'Text' => 'A shadowy aura filled the sky!'
        ],
        'Strong Winds' => [
          'Text' => 'Mysterious strong winds are protecting Flying-type Pok&eacute;mon!'
        ],
      ];
    }
  }
