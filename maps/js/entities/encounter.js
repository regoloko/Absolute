class Encounter extends Phaser.Scene
{
  constructor(Name, Grid_Engine_ID, Properties, Type, Coords, Render_Instance)
  {
    super();

    this.Name = Name;
    this.Grid_Engine_ID = Grid_Engine_ID;
    this.Render_Instance = Render_Instance;
    this.properties = Properties;
    this.type = Type;
    this.coords = Coords;
  }

  /**
   * Display the currently active encounter to the player.
   */
  DisplayEncounter(Steps_Till_Encounter, In_Encounter)
  {
    MapGame.Network.SendRequest('Encounter').then((Encounter) => {
      Encounter = JSON.parse(Encounter);

      if ( Encounter.Generated_Encounter.Type !== 'Normal' )
        alert(`You found a wild ${Encounter.Generated_Encounter.Type} Pok&eacute;mon!`);

      document.getElementById('map_dialogue').innerHTML = `
        A wild <b>${Encounter.Generated_Encounter.Pokedex_Data.Display_Name}</b> appeared!
        <br />
        <img src='${Encounter.Generated_Encounter.Pokedex_Data.Sprite}' />
        <br />
        <b>${Encounter.Generated_Encounter.Pokedex_Data.Display_Name}</b>
        ${Encounter.Generated_Encounter.Gender.charAt(0)}
        (Level: ${Encounter.Generated_Encounter.Level.toLocaleString()})

        <br /><br />

        <div class='flex wrap' style='gap: 10px; justify-content: center; max-width: 240px;'>
          <button style='flex-basis: 100px;' onclick='MapGame.Player.FightEncounter();'>Fight</button>
          <button style='flex-basis: 100px;' onclick='MapGame.Player.CatchEncounter();'>Catch</button>
          <button style='flex-basis: 100px;' onclick='MapGame.Player.ReleaseEncounter();'>Release</button>
          <button style='flex-basis: 100px;' onclick='MapGame.Player.RunFromEncounter();'>Run</button>
        </div>
      `;
    });
  }
}
