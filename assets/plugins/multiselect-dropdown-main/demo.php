<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-wEmeIV1mKuiNpC+IOBjI7aAzPcEZeedi5yW5f2yOq55WWLwNGmvvx4Um1vskeMj0" crossorigin="anonymous">

    <title>Multiselect-dropdown demo!</title>

<style>
  select {width: 20em;}
</style>
  </head>
  <body>
    <div class="container">
      <h1>Multiselect-dropdown demo!</h1>
      <div class="row"><div class="col ">
        <label>Select 1</label>
        
        <select name="field1" id="field1" multiple onchange="console.log(Array.from(this.selectedOptions).map(x=>x.value??x.text))" multiselect-hide-x="true">
          <option value="1">Audi</option>
          <option selected value="2">BMW</option>
          <option selected value="3">Mercedes</option>
          <option value="4">Volvo</option>
          <option value="5">Lexus</option>
          <option value="6">Tesla</option>
        </select>

<hr/>
        <label>Select 2</label>
        <select name="field2" id="field2" multiple multiselect-search="true" multiselect-select-all="true" multiselect-max-items="10" onchange="console.log(this.selectedOptions)">
          <option selected>Abarth</option>
          <option>Alfa Romeo</option>
          <option>Aston Martin</option>
          <option>Audi</option>
          <option>Bentley</option>
          <option>BMW</option>
          <option>Bugatti</option>
          <option>Cadillac</option>
          <option>Chevrolet</option>
          <option>Chrysler</option>
          <option>Citroën</option>
          <option>Dacia</option>
          <option>Daewoo</option>
          <option>Daihatsu</option>
          <option>Dodge</option>
          <option>Donkervoort</option>
          <option>DS</option>
          <option>Ferrari</option>
          <option>Fiat</option>
          <option>Fisker</option>
          <option>Ford</option>
          <option>Honda</option>
          <option>Hummer</option>
          <option>Hyundai</option>
          <option>Infiniti</option>
          <option>Iveco</option>
          <option>Jaguar</option>
          <option>Jeep</option>
          <option>Kia</option>
          <option>KTM</option>
          <option>Lada</option>
          <option>Lamborghini</option>
          <option>Lancia</option>
          <option>Land Rover</option>
          <option>Landwind</option>
          <option>Lexus</option>
          <option>Lotus</option>
          <option>Maserati</option>
          <option>Maybach</option>
          <option>Mazda</option>
          <option>McLaren</option>
          <option>Mercedes-Benz</option>
          <option>MG</option>
          <option>Mini</option>
          <option>Mitsubishi</option>
          <option>Morgan</option>
          <option>Nissan</option>
          <option>Opel</option>
          <option>Peugeot</option>
          <option>Porsche</option>
          <option>Renault</option>
          <option>Rolls-Royce</option>
          <option>Rover</option>
          <option>Saab</option>
          <option>Seat</option>
          <option>Skoda</option>
          <option>Smart</option>
          <option>SsangYong</option>
          <option>Subaru</option>
          <option>Suzuki</option>
          <option>Tesla</option>
          <option>Toyota</option>
          <option>Volkswagen</option>
          <option>Volvo</option>
        </select>

      </div></div>
      
<br/><br/><br/>
      <button class="btn btn-light" onclick="field2.innerHTML='<option value=1>New option 1</option><option selected value=2>New option 2</option><option value=3>New option 3</option>';field2.loadOptions()">Load new options</button>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-p34f1UUtsS3wqzfto5wAAmdvj+osOnFyQFpp4Ua3gs/ZVWx6oOypYoCJhGGScy+8" crossorigin="anonymous"></script>
    <script src="multiselect-dropdown.js" ></script>
  </body>
</html>
