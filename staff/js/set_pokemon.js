/**
 * Show a table for all unique areas where Pokemon can be obtained, given the specified database table.
 *
 * @param Database_Table
 */
function ShowObtainablePokemonByTable(Database_Table)
{
  let Form_Data = new FormData();
  Form_Data.append('Database_Table', Database_Table);
  Form_Data.append('Action', 'Show');

  SendRequest('set_pokemon', Form_Data)
    .then((Obtainable_Pokemon) => {
      const Obtainable_Pokemon_Data = JSON.parse(Obtainable_Pokemon);

      document.getElementById('Set_Pokemon_Table').innerHTML = Obtainable_Pokemon_Data.Obtainable_Table;
    });
}

/**
 * Show all obtainable Pokemon given a specified database table and location.
 *
 * @param Database_Table
 * @param Obtainable_Location
 */
function ShowObtainablePokemonByLocation(Database_Table, Obtainable_Location)
{
  let Form_Data = new FormData();
  Form_Data.append('Database_Table', Database_Table);
  Form_Data.append('Obtainable_Location', Obtainable_Location);
  Form_Data.append('Action', 'Show_Location');

  SendRequest('set_pokemon', Form_Data)
    .then((Obtainable_Pokemon) => {
      const Obtainable_Pokemon_Data = JSON.parse(Obtainable_Pokemon);

      document.getElementById('Set_Pokemon_Table').innerHTML = Obtainable_Pokemon_Data.Obtainable_Table;
    });
}
