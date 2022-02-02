<?php
  /**
   * Display a table that allows modification of a given Pokemon.
   *
   * @param $Pokemon_ID
   */
  function ShowPokemonModTable
  (
    $Pokemon_ID
  )
  {
    global $Poke_Class;

    $Pokemon_Info = $Poke_Class->FetchPokemonData($Pokemon_ID);

    $Frozen_Status = false;
    $Frozen_Text = '';
    if ( $Pokemon_Info['Frozen'] )
    {
      $Frozen_Status = true;
      $Frozen_Text = '<div><i>This Pok&eacute;mon is <b>frozen</b> and bound to its owner\'s account.</i></div>';
    }

    $Pokemon_Moves = [
      '1' => $Poke_Class->FetchMoveData($Pokemon_Info['Move_1']),
      '2' => $Poke_Class->FetchMoveData($Pokemon_Info['Move_2']),
      '3' => $Poke_Class->FetchMoveData($Pokemon_Info['Move_3']),
      '4' => $Poke_Class->FetchMoveData($Pokemon_Info['Move_4']),
    ];

    $Nature_Keys = array_keys($Poke_Class->Natures());
    $Nature_Options = '';
    foreach ( $Nature_Keys as $Nature )
      $Nature_Options .= "<option value='{$Nature}'>{$Nature}</option>";

    $Abilities = $Poke_Class->FetchAbilities($Pokemon_Info['Pokedex_ID'], $Pokemon_Info['Alt_ID']);
    $Ability_Options = '';
    foreach ( $Abilities as $Ability )
      if ( !empty($Ability) )
        $Ability_Options .= "<option value='{$Ability}'>{$Ability}</option>";

    return "
      <input type='hidden' name='Pokemon_ID_To_Update' value='{$Pokemon_ID}}' />
      <input type='hidden' name='Pokemon_Freeze_Status' value='{$Frozen_Status}' />

      <table class='border-gradient' style='width: 500px;'>
        <thead>
          <tr>
            <th colspan='4'>
              Modifying Pok&eacute;mon #{$Pokemon_Info['ID']}
            </th>
          </tr>
        </thead>

        <tbody>
          <tr>
            <td colspan='4' style='width: 100%;'>
              <img src='{$Pokemon_Info['Sprite']}' />
              <br />
              <b>{$Pokemon_Info['Display_Name']}</b>
              {$Frozen_Text}
            </td>
          </tr>

          <tr>
            <td colspan='2' style='width: 50%;'>
              <h3>Level</h3>
            </td>
            <td colspan='2' style='width: 50%;'>
              <input type='text' name='Level' value='{$Pokemon_Info['Level_Raw']}' />
            </td>
          </tr>

          <tr>
            <td colspan='2' style='width: 50%;'>
              <h3>Gender</h3>
            </td>
            <td colspan='2' style='width: 50%;'>
              <select name='Gender' style='padding: 4px; text-align: center; width: 180px;'>
                <option value='Ungendered'>(?)</option>
                <option value='Genderless'>Genderless</option>
                <option value='Female'>Female</option>
                <option value='Male'>Male</option>
              </select>
            </td>
          </tr>

          <tr>
            <td colspan='2' style='width: 50%;'>
              <h3>Nature</h3>
            </td>
            <td colspan='2' style='width: 50%;'>
              <select name='Nature' style='padding: 4px; text-align: center; width: 180px;'>
                {$Nature_Options}
              </select>
            </td>
          </tr>

          <tr>
            <td colspan='2' style='width: 50%;'>
              <h3>Ability</h3>
            </td>
            <td colspan='2' style='width: 50%;'>
              <select name='Ability' style='padding: 4px; text-align: center; width: 180px;'>
                {$Ability_Options}
              </select>
            </td>
          </tr>
        </tbody>

        <tbody>
          <tr>
            <td colspan='4' style='width: 50%;'>
              <h3>Moves</h3>
            </td>
          </tr>
          <tr>
            <td colspan='2' style='width: 50%;'>
              <div id='{$Pokemon_ID}_Move_1' onclick='SelectMove(\"{$Pokemon_ID}\", 1);' style='padding: 3px 0px;'>
                {$Pokemon_Moves['1']['Name']}
              </div>
            </td>
            <td colspan='2' style='width: 50%;'>
              <div id='{$Pokemon_ID}_Move_2' onclick='SelectMove(\"{$Pokemon_ID}\", 2);' style='padding: 3px 0px;'>
                {$Pokemon_Moves['2']['Name']}
              </div>
            </td>
          </tr>
          <tr>
            <td colspan='2' style='width: 50%;'>
              <div id='{$Pokemon_ID}_Move_3' onclick='SelectMove(\"{$Pokemon_ID}\", 3);' style='padding: 3px 0px;'>
                {$Pokemon_Moves['3']['Name']}
              </div>
            </td>
            <td colspan='2' style='width: 50%;'>
              <div id='{$Pokemon_ID}_Move_4' onclick='SelectMove(\"{$Pokemon_ID}\", 4);' style='padding: 3px 0px;'>
                {$Pokemon_Moves['4']['Name']}
              </div>
            </td>
          </tr>
        </tbody>

        <tbody>
          <tr>
            <td colspan='4' style='padding: 10px; width: 100%;'>
              <button>
                Update Pok&eacute;mon
              </button>
            </td>
          </tr>
        </tbody>
      </table>

      <br />

      <table style='width: 600px;'>
        <tbody>
          <tr>
            <td colspan='1' style='padding: 10px; width: 50%;'>
              <button>
                Delete Pok&eacute;mon
              </button>

              <br /><br />

              <i>
                This effectively releases the Pok&eacute;mon from the owner's account.
              </i>
            </td>

            <td colspan='1' style='padding: 10px; width: 50%;'>
              <button onclick='TogglePokemonFreeze();'>
                Freeze Pok&eacute;mon
              </button>

              <br /><br />

              <i>
                This prevents the Pok&eacute;mon from leaving the owner's account.
              </i>
            </td>
          </tr>
        </tbody>
      </table>
    ";
  }

  /**
   * Display a list of selectable moves that a Pokemon can learn.
   *
   * @param $Pokemon_ID
   * @param $Move_Slot
   */
  function ShowMoveList
  (
    $Pokemon_ID,
    $Move_Slot
  )
  {
    global $PDO;

    try
    {
      $Fetch_Moves = $PDO->prepare("
        SELECT *
        FROM `moves`
        WHERE `usable` = 1
      ");
      $Fetch_Moves->execute([ ]);
      $Fetch_Moves->setFetchMode(PDO::FETCH_ASSOC);
      $Move_List = $Fetch_Moves->fetchAll();
    }
    catch ( PDOException $e )
    {
      HandleError( $e->getMessage() );
    }

    if ( !$Move_List )
      return '';

    $Move_Options = '';
    foreach ( $Move_List as $Key => $Value )
      $Move_Options .= "<option value='{$Value['ID']}'>{$Value['Name']}</i>";

    return "
      <select name='{$Pokemon_ID}_Move_{$Move_Slot}' onchange='UpdateMove({$Pokemon_ID}, {$Move_Slot}, this);'>
        <option>Select A Move</option>
        <option value>---</option>
        {$Move_Options}
      </select>
    ";
  }

  /**
   * Update the selected move of a Pokemon.
   *
   * @param $Pokemon_ID
   * @param $Move_Slot
   * @param $Move_ID
   */
  function UpdateMove
  (
    $Pokemon_ID,
    $Move_Slot,
    $Move_ID
  )
  {
    global $PDO, $Poke_Class;

    $Pokemon_Data = $Poke_Class->FetchPokemonData($Pokemon_ID);

    $Current_Moves = [
      $Pokemon_Data['Move_1'],
      $Pokemon_Data['Move_2'],
      $Pokemon_Data['Move_3'],
      $Pokemon_Data['Move_4'],
    ];

    if ( count(array_unique($Current_Moves)) != 4 )
    {
      return [
        'Success' => false,
        'Message' => "<div class='error'>You may not have the same move more than once.</div>",
      ];
    }
    else
    {
      try
      {
        $PDO->beginTransaction();

        $Update_Moves = $PDO->prepare("
          UPDATE `pokemon`
          SET `Move_{$Move_Slot}` = ?
          WHERE `ID` = ?
          LIMIT 1
        ");
        $Update_Moves->execute([
          $Move_ID,
          $Pokemon_ID
        ]);

        $PDO->commit();
      }
      catch( PDOException $e )
      {
        $PDO->rollBack();

        HandleError($e);
      }

      return [
        'Success' => true,
        'Message' => "<b>{$Pokemon_Data['Display_Name']}'s</b> moves have been updated successfully.",
      ];
    }
  }
