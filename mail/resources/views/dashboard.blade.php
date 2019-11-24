@extends('layouts.master')

@section('title', '- DashBoard')

@section('content-header', 'DashBoard')

@section('breadcrumb')
    <li class="active">Dashboard</li>
@endsection

@section('content')
<section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3>{{ $sendMail }}</h3>

              <p>Sent Mails</p>
            </div>
            <div class="icon">
              <i class="fa fa-paper-plane-o"></i>
            </div>
            <a href="{{ url('/sendMail') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3>{{ $emails }}</h3>

              <p>Total Accounts</p>
            </div>
            <div class="icon">
              <i class="fa fa-id-card-o"></i>
            </div>
            <a href="{{ url('/email') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3>{{ $smtp }}</h3>

              <p>Total Mailers</p>
            </div>
            <div class="icon">
              <i class="fa fa-server"></i>
            </div>
            <a href="{{ url('/mailer') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-purple">
            <div class="inner">
              <h3>{{ $users }}</h3>

              <p>Total Users</p>
            </div>
            <div class="icon">
              <i class="fa fa-users"></i>
            </div>
            <a href="{{ url('/user') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
      </div>
      <!-- /.row (main row) -->

      <div class="row text-center">
          <br><br>
          <img src="{{ asset($settings[1]['value']) }}" alt="Logo">
          <h2>{{ $settings[3]['value'] }}</h2>
      </div>

    </section>
@endsection
