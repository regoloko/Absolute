<?php
  error_reporting(-1);
  ini_set('display_errors', 'On');

  require_once '../classes/battle.php';

  spl_autoload_register(function($Class)
  {
    $Battle_Directory = dirname(__DIR__, 1);
    $Class = strtolower($Class);

    if (file_exists($Battle_Directory . "/classes/{$Class}.php"))
      require_once $Battle_Directory . "/classes/{$Class}.php";

    if (file_exists($Battle_Directory . "/fights/{$Class}.php"))
      require_once $Battle_Directory . "/fights/{$Class}.php";
  });

  require_once '../../core/required/session.php';

  if ( empty($_SESSION['Battle']) )
  {
    $Output['Message'] = 'You do not have a valid Battle session.';
    $_SESSION['Battle']['Dialogue'] = $Output['Message'];

    echo json_encode($Output);
  }

  $Fight = $_SESSION['Battle']['Battle_Type'];

  switch ($Fight)
  {
    case 'trainer':
      $Foe = $_SESSION['Battle']['Foe_ID'];
      $Battle = new Trainer($User_Data['ID'], $Foe);
      break;

    default:
      $Foe = $_SESSION['Battle']['Foe_ID'];
      $Battle = new Trainer($User_Data['ID'], $Foe);
      break;
  }

  $Output = [
    'Time_Started' => $_SESSION['Battle']['Time_Started'],
    'Battle_Type' => $_SESSION['Battle']['Battle_Type'],
    'Started' => $_SESSION['Battle']['Started'],
    'Battle_ID' => $_SESSION['Battle']['Battle_ID'],
    'Turn_ID' => $_SESSION['Battle']['Turn_ID'],
  ];

  /**
   * Process the desired battle action.
   */
  if
  (
    isset($_POST['Action']) &&
    $_POST['Action'] != 'null' &&
    isset($_POST['Data']) &&
    $_POST['Data'] != 'null'
  )
  {
    if ( isset($_POST['Client_X']) )
      $_SESSION['Battle']['Logging']['Input']['Client_X'] = Purify($_POST['Client_X']);

    if ( isset($_POST['Client_Y']) )
      $_SESSION['Battle']['Logging']['Input']['Client_Y'] = Purify($_POST['Client_Y']);

    if ( isset($_POST['Input_Type']) )
      $_SESSION['Battle']['Logging']['Input']['Type'] = Purify($_POST['Input_Type']);

    if ( isset($_POST['Is_Trusted']) )
      $_SESSION['Battle']['Logging']['Input']['Is_Trusted'] = Purify($_POST['Is_Trusted']);

    if ( isset($_POST['Battle_ID']) )
      $_SESSION['Battle']['Logging']['Battle_ID'] = Purify($_POST['Battle_ID']);
    else
      $_SESSION['Battle']['Logging']['Battle_ID'] = 'Battle ID - Not Sent';

    if ( isset($_POST['In_Focus']) )
      $_SESSION['Battle']['Logging']['In_Focus'] = Purify($_POST['In_Focus']);

    $Action = Purify($_POST['Action']);
    $Data = Purify($_POST['Data']);

    $Turn_Data = $Battle->ProcessTurn($Action, $Data);

    $Output['Message'] = $Turn_Data;
  }
  else
  {
    if ( !empty($_SESSION['Battle']['Dialogue']) )
    {
      $Output['Message'] = $_SESSION['Battle']['Dialogue'];
    }
    else
    {
      $Output['Message'] = [
        'Type' => 'Success',
        'Text' => 'The battle has begun.'
      ];
    }
  }

  foreach ( ['Ally', 'Foe'] as $Side )
  {
    $Output[$Side] = $_SESSION['Battle'][$Side];
  }

  if ( !empty($_SESSION['Battle']['Weather']) )
  {
    $Output['Weather'] = $_SESSION['Battle']['Weather'];
  }

  if ( !empty($_SESSION['Battle']['Field_Effects']) )
  {
    $Output['Field_Effects'] = $_SESSION['Battle']['Field_Effects'];
  }

  if ( !empty($_SESSION['Battle']['Terrain']) )
  {
    $Output['Terrain'] = $_SESSION['Battle']['Terrain'];
  }

  $_SESSION['Battle']['Dialogue'] = $Output['Message'];

  echo json_encode($Output);