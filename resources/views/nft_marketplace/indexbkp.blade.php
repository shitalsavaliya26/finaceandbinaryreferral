@extends('layouts.app')

@section('content')
 <div class="content-wrapper">
          <div class="row mt-5 pt-5">
            <div class="col-12">
              <p class="text-white">NFT Collection</p>
            </div>
            <div class="col-12 col-md-6 col-lg-4">
              <div class="bg-bullkong rounded d-flex flex-column align-items-center justify-content-center text-white">
                <h3>BULL KONG</h3>
                <h3>COLLECTION</h3>
              </div>
            </div>
            <div class="col-12 col-md-6 col-lg-4 mt-4 mt-md-0">
              <div class="bg-newface rounded d-flex flex-column align-items-center justify-content-center text-white">
                <h3>NEW FACE</h3>
                <h3>COLLECTION</h3>
              </div>
            </div>
            <div class="col-12 col-md-6 col-lg-4 mt-4 mt-lg-0">
              <div class="bg-hoppertrophy rounded d-flex flex-column align-items-center justify-content-center text-white">
                <h3>HOPPER TROPHY</h3>
                <h3>COLLECTION</h3>
              </div>
            </div>
          </div>
          <div class="row mt-5">
            <div class="col-12">
              <p class="text-white">Bull Kong’s Collection</p>
            </div>
            <div class="col-12">
              <div class="bull-kong-slider">
                <div>
                  <a class="min-h-240 bg-white p-3 rounded mx-2 d-block"  href="{{route('nftproduct')}}">
                    <img src="{{ asset('assets/images/assets/NFT_Marketplace/Group1044.png') }}" class="img-fluid mx-auto" alt="">
                    <div class="mt-3">
                      <h4 class="text-blue font-weight-bold">BULL KONG #7097</h4>
                      <h3 class="text-black font-weight-bold">$20,000</h3>
                    </div>
                  </a>
                </div>
                <div>
                  <div class="min-h-240 bg-white p-3 rounded mx-2">
                    <img src="{{ asset('assets/images/assets/NFT_Marketplace/Group1045.png') }}" class="img-fluid mx-auto" alt="">
                    <div class="mt-3">
                      <h4 class="text-blue font-weight-bold">KONG #7097</h4>
                      <h3 class="text-black font-weight-bold">$20,000</h3>
                    </div>
                  </div>
                </div>
                <div>
                  <div class="min-h-240 bg-white p-3 rounded mx-2">
                    <img src="{{ asset('assets/images/assets/NFT_Marketplace/Group1046.png') }}" class="img-fluid mx-auto" alt="">
                    <div class="mt-3">
                      <h4 class="text-blue font-weight-bold">KONG BOSS#7097</h4>
                      <h3 class="text-black font-weight-bold">$20,000</h3>
                    </div>
                  </div>
                </div>
                <div>
                  <div class="min-h-240 bg-white p-3 rounded mx-2">
                    <img src="{{ asset('assets/images/assets/NFT_Marketplace/Group1047.png') }}" class="img-fluid mx-auto" alt="">
                    <div class="mt-3">
                      <h4 class="text-blue font-weight-bold">BULL KONG #7097</h4>
                      <h3 class="text-black font-weight-bold">$20,000</h3>
                    </div>
                  </div>
                </div>
                <div>
                  <div class="min-h-240 bg-white p-3 rounded mx-2">
                    <img src="{{ asset('assets/images/assets/NFT_Marketplace/Group1048.png') }}" class="img-fluid mx-auto" alt="">
                    <div class="mt-3">
                      <h4 class="text-blue font-weight-bold">KONG BOSS#7097</h4>
                      <h3 class="text-black font-weight-bold">$20,000</h3>
                    </div>
                  </div>
                </div>
                <div>
                  <div class="min-h-240 bg-white p-3 rounded mx-2">
                    <img src="{{ asset('assets/images/assets/NFT_Marketplace/Group1045.png') }}" class="img-fluid mx-auto" alt="">
                    <div class="mt-3">
                      <h4 class="text-blue font-weight-bold">KONG BOSS#7097</h4>
                      <h3 class="text-black font-weight-bold">$20,000</h3>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row mt-5">
            <div class="col-12">
              <p class="text-white">New Face’s Collection</p>
            </div>
            <div class="col-12">
              <div class="bull-kong-slider">
                <div>
                  <div class="min-h-240 bg-white p-3 rounded mx-2">
                    <img src="{{ asset('assets/images/assets/NFT_Marketplace/Group1051.png') }}" class="img-fluid mx-auto" alt="">
                    <div class="mt-3">
                      <h4 class="text-blue font-weight-bold">NEW FACE #083</h4>
                      <h3 class="text-black font-weight-bold">$20,000</h3>
                    </div>
                  </div>
                </div>
                <div>
                  <div class="min-h-240 bg-white p-3 rounded mx-2">
                    <img src="{{ asset('assets/images/assets/NFT_Marketplace/Group1050.png') }}" class="img-fluid mx-auto" alt="">
                    <div class="mt-3">
                      <h4 class="text-blue font-weight-bold">NEW FACE #0</h4>
                      <h3 class="text-black font-weight-bold">$20,000</h3>
                    </div>
                  </div>
                </div>
                <div>
                  <div class="min-h-240 bg-white p-3 rounded mx-2">
                    <img src="{{ asset('assets/images/assets/NFT_Marketplace/Group1049.png') }}" class="img-fluid mx-auto" alt="">
                    <div class="mt-3">
                      <h4 class="text-blue font-weight-bold">NEW FACE#110</h4>
                      <h3 class="text-black font-weight-bold">$20,000</h3>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
@endsection