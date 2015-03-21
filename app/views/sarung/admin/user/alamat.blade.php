				<label for="result_alamat_name" class="col-sm-3 control-label" >Result Alamat</label>
				<div class="col-sm-9">
					@if ($desas)
						<select class="form-control input-sm" name="result_alamat_name">
							@foreach( $desas as $val )
								<option value="{{ $val->id }}"
									@if ( $val->id === (int) $current_desa ) )
										selected
									@endif
								>
									{{ $val->kecamatan->nama }} | {{ $val->nama }}
								</option>
							@endforeach
						</select>
					@endif
				</div>
