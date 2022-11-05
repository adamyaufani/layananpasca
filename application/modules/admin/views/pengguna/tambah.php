<div class="row">
	<div class="col-md-12">

		<?php if(isset($msg) || validation_errors() !== ''): ?>
		<div class="alert alert-danger alert-dismissible">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
			<h4><i class="fa fa-exclamation"></i> Terjadi Kesalahan</h4>
			<?= validation_errors();?>
			<?= isset($msg)? $msg: ''; ?>
		</div>
		<?php endif; ?>

	</div>

	<div class="col-md-6">
		<div class="card card-success card-outline">
			<div class="card-body box-profile">

				<?php echo form_open_multipart(base_url('admin/pengguna/tambah'), '' )?>
				<div class="form-group">
					<label for="username" class="control-label">Username</label>
					<div class="">
						<input type="text" name="username" class="form-control <?= (form_error('username')) ? 'is-invalid' : ''; ?>" id="username" placeholder="" value="<?php if(validation_errors()) {echo set_value('username');  }  ?>" >
						<span class="text-danger"><?php echo form_error('username'); ?></span>
					</div>
				</div>

				<div class="form-group">
					<label for="nidn" class="control-label">Email</label>
					<div>
						<input type="email" name="email" class="form-control <?= (form_error('email')) ? 'is-invalid' : ''; ?>" id="email" placeholder="" value="<?php if(validation_errors()) {echo set_value('email');  }  ?>" >
						<span class="text-danger"><?php echo form_error('email'); ?></span>
					</div>
				</div>

				<div class="form-group">
					<label for="nik" class="control-label">NIK</label>
					<div>
						<input type="nik" name="nik" class="form-control <?= (form_error('nik')) ? 'is-invalid' : ''; ?>" id="nik" placeholder="" value="<?php if(validation_errors()) {echo set_value('nik');  }  ?>" >
						<span class="text-danger"><?php echo form_error('nik'); ?></span>
					</div>
				</div>

				<div class="form-group">
					<label for="nidn" class="control-label">NIDN</label>
					<div>
						<input type="nidn" name="nidn" class="form-control <?= (form_error('nidn')) ? 'is-invalid' : ''; ?>" id="nidn" placeholder="" value="<?php if(validation_errors()) {echo set_value('nidn');  }  ?>" >
						<span class="text-danger"><?php echo form_error('nidn'); ?></span>
					</div>
				</div>

				<div class="form-group">
					<label for="password" class="control-label">Password</label>
					<div>
						<input type="password" name="password" class="form-control <?= (form_error('password')) ? 'is-invalid' : ''; ?>" id="password" >
						<span class="text-danger"><?php echo form_error('password'); ?></span>
					</div>
				</div>
				<div class="form-group">
					<label for="nama" class="control-label">Nama Lengkap</label>
					<div class="">
						<input type="text" name="nama" class="form-control <?= (form_error('nama')) ? 'is-invalid' : ''; ?>" id="nama" placeholder="" value="<?php if(validation_errors()) {echo set_value('nama');  }  ?>" >
						<span class="text-danger"><?php echo form_error('nama'); ?></span>
					</div>
				</div>

				<div class="form-group">
					<label for="role" class="control-label">Role</label>
					<div>
						<select name="role" class="form-control <?= (form_error('role')) ? 'is-invalid' : ''; ?>">
							<option value="">Pilih Role</option>
							<?php foreach($role as $row) { ?>
							<option value="<?=$row['id']; ?>" <?= (set_select('role', $row['id']))?>><?=$row['role']; ?></option>
							<?php } ?>
						</select>
						<span class="text-danger"><?php echo form_error('role'); ?></span>
					</div>
				</div>

			
				<div class="form-group">
					<label for="id_prodi" class="control-label">Program Studi</label>
					<div>
						<select name="id_prodi" class="form-control <?= (form_error('id_prodi')) ? 'is-invalid' : ''; ?>">
							<option value="">Pilih Program Studi </option>
							<?php foreach($prodi as $row) { ?>
							<option value="<?=$row['id']; ?>" <?= (set_select('id_prodi', $row['id']))?>><?=$row['prodi']; ?></option>
							<?php } ?>
						</select>
						<span class="text-danger"><?php echo form_error('id_prodi'); ?></span>
					</div>
				</div>

				<div class="form-group">
					<div>
						<input type="submit" name="submit" value="Tambah Pengguna" class="btn btn-md btn-perak">
			
					</div>
				</div>
				<?php echo form_close( ); ?>

			</div>
		</div>
	</div>

</div>