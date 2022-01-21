function ShowSprites(Category, Sub_Category = null)
{
  SendRequest('sprite_list', { Category: Category, Sub_Category: Sub_Category })
    .then((Sprites) => {
      document.getElementById('Sprite_AJAX').innerHTML = Sprites;
    })
    .catch((Error) => console.log('Error:', Error));
}
