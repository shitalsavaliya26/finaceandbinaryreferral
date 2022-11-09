<!DOCTYPE html>
<html>

<head>
  <meta content="width=device-width,initial-scale=1" name="viewport">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <style type="text/css">
     @import url('http://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700');
    html {
      width: 100% !important;
    }
    
    body {
      width: 100% !important;
      margin: 0;
      padding: 0;
      font-family: poppins;
    }
  </style>
</head>

<body style="background-image: url({{ asset('assets/receipt/cert-background.jpg') }}); -webkit-background-size:100%; -moz-background-size:100%; -o-background-size:100%; background-size:100%; background-position:center; background-repeat:no-repeat; padding-top: 50px;">
  <table width="100%" cellpadding="0" cellspacing="0" border="0" style=" margin-left: 120px;">
    <tr>
      <td align="center">
        <table width="80%">
          <tr>
            <td align="center" style="padding:45px 0px;">
              <a style="text-decoration:none; outline:none;" href="#" title="Vextrader">
                <img src="{{ asset('assets/receipt/logo-white.png') }}" width="350" style="display:block;" />
              </a>
            </td>
          </tr>
        </table>

        <table width="80%" style="padding-top: 10px;">
          <tr>
            <td  align="center" style="font-weight:600; font-size:42px; color:#ffc424; font-family:poppins; text-align:center; line-height:42px;">
              CERTIFICATE
              <br> 
              <span style="font-weight: normal; font-size:28px;  color: white;">OF DEPOSIT</span>
            </td>
          </tr>
        </table>
       
        <table width="80%" style="padding-top: 50px;">
          <tr>
            <td  align="center" style="font-size:16px; color:white; font-family:poppins; text-align:center;">
              THIS IS TO CERTIFY THAT:
            </td>
          </tr>
          <tr>
            <td style="font-weight: bold; font-size:40px; color:white; font-family:poppins; text-align:center;">
              <span style="width: 30%; border-bottom: 2px dashed white;">[&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;]</span>
            </td>
          </tr>
        </table>

        <table width="80%" style="padding-top: 30px;">
          <tr>
            {{-- <td  align="center" style="font-size:16px; color:white; font-family:poppins; text-align:center; display: flex; justify-content: space-between;"> --}}
              <td  align="center" style="font-size:16px; color:white; font-family:poppins; text-align:center;">
              {{-- <span style="display: flex; align-items: center; width: 50%;">
                Name: <input type="text" style="color:white;border: 1px solid white; background-color: transparent; padding:10px; margin-left: auto; width: 73%;" value="{{ $user->name ?? "" }}">
              </span>
              <span style="display: flex; align-items: center;">
                FUNDING METHOD: <form style="display: flex; align-items: center;">
                  <input type="checkbox" id="vehicle1" name="vehicle1" style="margin-left: 10px;" value="USDT" checked>
                  <label for="vehicle1" style="margin-left: 5px;"> USDT</label><br>
                  <input type="checkbox" id="vehicle2" name="vehicle2" style="margin-left: 10px;" value="BANK">
                  <label for="vehicle2" style="margin-left: 5px;"> BANK</label><br>
                </form>
              </span> --}}
              <div style="width: 10%;display:inline-block;">
                <span style="font-size:16px; color:white; font-family:poppins; vertical-align: center;"> Name</span>
              </div>
              <div style="width: 30%;display:inline-block;">
                <input type="text" style="color:white;border: 1px solid white; background-color: transparent; padding:10px; margin-left: auto; width: 73%;" value="{{ $user->name ?? "" }}">
              </div>
              <div style="width: 60%;display:inline-block;">
                <div style="width: 30%;display:inline-block;">
                  <span style="font-size:16px; color:white; font-family:poppins;">  FUNDING METHOD:</span>
                </div>
                <div style="width: 35%;display:inline-block;">
                  <input type="checkbox" id="vehicle1" name="vehicle1" style="margin-left: 10px;display:inline-block" value="USDT" checked>
                  <label for="vehicle1" style="margin-left: 5px;display:inline-block"> USDT</label><br>
                </div>
                <div style="width: 35%;display:inline-block;">
                  <input type="checkbox" id="vehicle2" name="vehicle2" style="margin-left: 10px;display:inline-block" value="BANK">
                  <label for="vehicle2" style="margin-left: 5px;display:inline-block"> BANK</label><br>
                </div>
             </div>
            </td>
          </tr>
        </table>

        <table width="80%" style="padding-top: 30px;">
          <tr>
            <td  align="center" style="font-size:16px; color:white; font-family:poppins; text-align:center;">
              {{-- <div style="display: flex; align-items: center;">
                FROM: <input type="text" style="border: 1px solid white;color:white;background-color: transparent; padding:10px; width: 87%; margin-left: auto;" value="{{ (!empty($usdt_address ?? " ")) ? ($usdt_address ?? "" ) : ("-") }}">
              </div> --}}
              <div style="width: 30%;display:inline-block;">
                <span style="font-size:16px; color:white; font-family:poppins;"> FROM:</span>
              </div>
              <div style="width: 60%;display:inline-block;">
                <input type="text" style="border: 1px solid white;color:white;background-color: transparent; padding:10px; width: 87%; margin-left: auto;" value="{{ (!empty($usdt_address ?? " ")) ? ($usdt_address ?? "" ) : ("-") }}">
              </div>
            </td>
          </tr>
        </table>
        <table width="80%" style="padding-top: 30px;">
          <tr>
            <td  align="center" style="font-size:16px; color:white; font-family:poppins; text-align:center;">
              {{-- <div style="display: flex; align-items: center;">
                DEPOSITED THE SUM OF: <input type="text" style="border: 1px solid white; background-color: transparent; padding:10px; width: 65%;  margin-left: auto;color:white" value="{{ $amount ?? ""}}">
              </div> --}}

              <div style="width: 30%;display:inline-block;">
                <span style="font-size:16px; color:white; font-family:poppins;">  DEPOSITED THE SUM OF:</span>
              </div>
              <div style="width: 60%;display:inline-block;">
                <input type="text" style="border: 1px solid white;color:white;background-color: transparent; padding:10px; width: 87%; margin-left: auto;" value="{{ $amount ?? ""}}">
              </div>

            </td>
          </tr>
        </table>

        <table width="80%" style="padding-top: 50px;">
          <tr>
            <td  align="center" style="font-weight: bold; font-size:25px; color:white; font-family:poppins; text-align:center;">
              SERIAL NUMBER:
            </td>
          </tr>
          <tr>
            <td style="font-weight: bold; font-size:25px; color:white; font-family:poppins; text-align:center;">
              <span style="width: 60%; border-bottom: 2px dashed white;">[ {{ $serialnumber ??  ""}} ]</span>
            </td>
          </tr>
        </table>

        <table width="80%" style="padding-top: 80px;">
          <tr>
            <td  align="center" style="font-size:16px; color:white; font-family:poppins;">
                <div style="width: 30%;display:inline-block;">
                  <p></p>
                  <p style="border-top: 2px solid #3cbcc7; width: 100%;"></p>
                  <span style="font-size:16px; color:white; font-family:poppins;"> SIGNATURE</span>
                </div>
                <div style="width: 30%;display:inline-block;"></div>
                <div style="width: 30%;display:inline-block;">
                  <p>{{ $created_date ?? ""}}</p>
                  <p style="border-top: 2px solid #3cbcc7; width: 100%;"></p>
                  <span style="font-size:16px; color:white; font-family:poppins;"> DATE</span>
                </div>
            </td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
</body>
</html>
