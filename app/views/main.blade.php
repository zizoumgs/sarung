@extends('layouts.onepage')

@section('title')
	Fatihul Ulum
@stop

@section('content')

	<hr>
		<h1 class="page-header text-center bold-font">Salam kaum bersarung</h1>
	<hr>
	<div class="row">
		<div class="col-md-9">
			<img class="thumbnail pull-left" src="{{ URL::to('/') }}/asset/images/fatihulUlum1.gif" weight=150 height=150 style="margin:6px 15px 0px 0px">
			<p style="text-align:justify">Sarung adalah sebuah applikasi yang dibuat untuk pondok pesantren Fatihul Ulum Manggisan Tanggul Jember
				baik diniyah atau non diniyah(meskipun pada kenyataanya keduanya sama-sama diniyah).
				Kami memilih nama sarung dikarenakan beberapa alasan
				Pertama: sarung merupakan tradisi pondok pesantren dan merupakan tradisi indonesia yang tidak perlu untuk dihilangkan!.
				Titik berat pada applikasi ini adalah klasement yang sangat menentukan siapa yang naik dan siapa yang tidak di pondok pesantren ini.
				akan tetapi dalam applikasi ini juga ada fungsi-fungsi lain yang juga tidak kalah penting .
				Harapan dari applikasi ini adalah guru dan pengurus bisa dengan mudah meng-akses siapa yang perlu bimbingan lebih banyak dan
				dari sini guru bisa melihat kemampuan siswa dalam segala pelajaran dan bisa juga melihat tract record
				nilai siswa atau nilai kelas secara umum. kami sudah lelah menjadi sekolah <b>antah berantah</b>.</p>
		</div>
		<div class="col-md-3">
			<a class="twitter-timeline"  href="https://twitter.com/zizoumgs/lists/our-friends"  data-widget-id="461428361286270976">Tweets from https://twitter.com/zizoumgs/lists/our-friends</a>
			<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>				
			@if(Auth::user())
            <ul class="list-group">
				<?php
					$outcome = Outcome_Model::sum('jumlah');
					$income  = Income_Model::sum('jumlah');
				?>
                <li href="#" class="list-group-item list-group-item-info disable"><b>Budget Information</b></a></li>
                <li href="#" class="list-group-item">Total Pengeluaran :
					<span class="pull-right">
						{{ root::get_rupiah_root($outcome ) }}
					</span>
				</li>
                <li href="#" class="list-group-item">Total Pemasukan :
					<span class="pull-right">
						{{ root::get_rupiah_root($income) }}
					</span>
				</li>
                <li href="#" class="list-group-item">Uang Sekarang :
					<span class="pull-right">
						{{ root::get_rupiah_root($income-$outcome) }}
					</span>
				</li>
            </ul>
			@endif
		</div>
	</div>		
@stop

