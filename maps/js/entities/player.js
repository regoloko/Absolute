class Player_Entity
{
  constructor(Sprite)
  {

  }

  Update(Time, Delta, GridEngine)
  {
    if (MapGame.Keys.left.isDown) {
      GridEngine.move("character", "left");
    } else if (MapGame.Keys.right.isDown) {
      GridEngine.move("character", "right");
    } else if (MapGame.Keys.up.isDown) {
      GridEngine.move("character", "up");
    } else if (MapGame.Keys.down.isDown) {
      GridEngine.move("character", "down");
    }

    //if (MapGame.Keys.left.isDown)
    //{
    //  this.CheckMove("left");
    //}
    //else if (MapGame.Keys.right.isDown)
    //{
    //  this.CheckMove("right");
    //}
    //else if (MapGame.Keys.up.isDown)
    //{
    //  this.CheckMove("up");
    //}
    //else if (MapGame.Keys.down.isDown)
    //{
    //  this.CheckMove("down");
    //}
  }

  CheckMove(Direction)
  {
    console.log('[Checking Movement]', Direction);
    console.log('[Checking Movement Layer]', MapGame.Layers);

    let Next_Tile;
    if ( Direction == 'left' ) Next_Tile = MapGame.Layers.getTileAtWorldXY(this.x - 16, this.y, true);
    else if ( Direction == 'right' ) Next_Tile = MapGame.Layers.getTileAtWorldXY(this.x + 16, this.y, true);
    else if ( Direction == 'up' ) Next_Tile = MapGame.Layers.getTileAtWorldXY(this.x, this.y - 16, true);
    else Next_Tile = MapGame.Layers.getTileAtWorldXY(this.x, this.y + 16, true);

    console.log('[Checking Movement Collision]', Next_Tile);
  }

  /**
   * Handle player input.
   */
  InputListener(Input, Layers)
  {
    Input.keyboard.on('keydown-A', (e) =>
    {
      var Tile_Info = Layers.getTileAtWorldXY(this.x - 16, this.y, true);
      if ( !Tile_Info || Tile_Info.properties.collision )
        return;

      this.play('walk_side');

      this.x -= 16;
      this.scaleX = 1;
    });

    Input.keyboard.on('keydown-D', (e) =>
    {
      var Tile_Info = Layers.getTileAtWorldXY(this.x + 16, this.y, true);
      if ( !Tile_Info || Tile_Info.properties.collision )
        return;

      this.play('walk_side');

      this.x += 16;
      this.scaleX = -1;
    });

    Input.keyboard.on('keydown-W', (e) =>
    {
      var Tile_Info = Layers.getTileAtWorldXY(this.x, this.y - 16, true);
      if ( !Tile_Info || Tile_Info.properties.collision )
        return;

      this.play('walk_up');

      this.y -= 16;
    });

    Input.keyboard.on('keydown-S', (e) =>
    {
      var Tile_Info = Layers.getTileAtWorldXY(this.x, this.y + 16, true);
      if ( !Tile_Info || Tile_Info.properties.collision )
        return;

      this.play('walk_down');

      this.y += 16;
    });
  }

  /**
   * Play the specified animation.
   */
  PlayAnimation(Animation_Name)
  {
    this.Sprite.anims.play(Animation_Name, true);
  }

  /**
   * Create animations.
   */
  CreateAnimations()
  {
    const Anims = this.Sprite.anims;
    Anims.create({
      key: 'walk-left',
      frames: Anims.generateFrameNames('character', {
        start: 0,
        end: 3,
        prefix: 'atlas-',
        suffix: '.png',
      }),
      frameRate: 10,
      repeat: false,
    });
    Anims.create({
      key: 'walk-right',
      frames: Anims.generateFrameNames('character', {
        start: 0,
        end: 3,
        prefix: 'atlas-',
        suffix: '.png',
      }),
      flipped: true,
      frameRate: 10,
      repeat: false,
    });
    Anims.create({
      key: 'walk-down',
      frames: Anims.generateFrameNames('character', {
        start: 8,
        end: 11,
        prefix: 'atlas-',
        suffix: '.png',
      }),
      frameRate: 10,
      repeat: false,
    });
    Anims.create({
      key: 'walk-up',
      frames: Anims.generateFrameNames('character', {
        start: 4,
        end: 7,
        prefix: 'atlas-',
        suffix: '.png',
      }),
      frameRate: 10,
      repeat: false,
    });
    Anims.create({
      key: 'idle-down',
      frames: Anims.generateFrameNames('character', {
        start: 8,
        end: 8,
        prefix: 'atlas-',
        suffix: '.png',
      }),
      frameRate: 10,
      repeat: false,
    });
  }
}
