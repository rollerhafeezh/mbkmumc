<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<div class="content__header content__boxed overlapping">
    <div class="content__wrap">
        
    </div>
</div>

<div class="content__boxed">
    <div class="content__wrap">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">

                        <div class="text-center">
                            <img src="<?= base_url('assets/img/mbkm_umc_color.png') ?>" class="img-fluid mb-4 mt-2 w-50">
                            <h4 class="mb-1">Registrasi Mahasiswa <span class="text-nowrap">Program Inbound</span></h4>
                            <p>Merdeka Belajar Kampus Merdeka</p>
                        </div>

                        <form class="mt-4" action="<?= base_url('mbkm/daftar') ?>" method="POST" onsubmit="recaptcha_validation(this, event)">
                            <?php if(isset($_SESSION['msg'])) { ?>
                                <div class="alert alert-<?=$_SESSION['msg'][0]?>"><?=$_SESSION['msg'][1]?></div>
                            <?php  } ?>

                            <div class="row g-3 mb-4">
                                <div class="col-12">
                                    <label class="form-label text-dark fw-bold" for="nik">Nomor Induk Kependudukan (NIK) <span class="text-danger">*</span></label>
                                    <input type="number" name="nik" id="nik" class="form-control" placeholder="Nomor Induk Kependudukan (NIK)" required="">
                                </div>
                                <div class="col-12">
                                    <label class="form-label text-dark fw-bold" for="mahasiswa">Cari Data Mahasiswa (PDDIKTI) <span class="text-danger">*</span></label>
                                    <input type="search" name="mahasiswa" id="mahasiswa" class="form-control" placeholder="Masukkan Nama atau Nomor Induk Mahasiswa (NIM)" required="" list="hit_mhs" autocomplete="off" onchange="castvote(this); document.querySelector('#asal_mahasiswa').value = document.querySelector(`#hit_mhs > option[value='${this.value}']`).dataset.asal_mahasiswa;" oninput="hit_mhs(this)">
                                    <small class="text-muted">* Pastikan kamu terdaftar di PDDIKTI Kemdikbud.</small>
                                    
                                    <datalist id="hit_mhs"></datalist>
	                                <input type="hidden" id="asal_mahasiswa" name="asal_mahasiswa">
                                </div>
                                <div class="col-12">
                                    <label class="form-label text-dark fw-bold" for="email">Email <span class="text-danger">*</span></label>
                                    <input type="email" id="email" name="email" class="form-control" placeholder="Email" required="">
                                    <small class="text-muted">* Pastikan email yang dimasukkan aktif.</small>
                                </div>
                                <div class="col-12">
                                    <label class="form-label text-dark fw-bold" for="no_hp">No. Handphone <span class="text-danger">*</span></label>
                                    <input type="tel" id="no_hp" name="no_hp" class="form-control" placeholder="Nomor Handphone (Whatsapp)" required="">
                                    <small class="text-muted">* Pastikan nomor handphone yang dimasukkan aktif.</small>
                                </div>
                            </div>

                            <div class="">
                                <style >
                                    .g-recaptcha div { margin-left: auto; margin-right: auto;}
                                </style>
                                
                                <div class="g-recaptcha" data-sitekey="6Le585ckAAAAAMFaRJqp2itYT8NzvzWIv1Ul2k5G"></div>
                                <!-- <input id="registerCheck" class="form-check-input" type="checkbox" required="">
                                <label for="registerCheck" class="form-check-label">
                                    Saya telah menyetujui syarat dan kebijakan yang berlaku.
                                </label> -->
                            </div>

                            <div class="d-grid mt-4">
                                <button class="btn btn-primary" type="submit"><i class="psi-paper-plane me-1"></i> Daftar</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function recaptcha_validation(e, evt) {
        var response = grecaptcha.getResponse()
        
        if (response.length == 0) {
            alert('Silahkan verifikasi captcha apabila anda bukan robot.')
            evt.preventDefault()
            return
        }
    }

    function hit_mhs(e) {
        if ( castvote(e, 'oninput') )
            return

        if (e.value == '') 
            document.querySelector('#hit_mhs').innerHTML = '';

        fetch('<?= base_url('mbkm/hit_mhs/') ?>' + e.value)
        .then(response => response.json())
        .then(json => {
            var options = ''
            json.data.forEach( function(e, i) {
                options += '<option value="' + e.mahasiswa + '" data-asal_mahasiswa="'+ e.detail +'">'+ e.detail +'</option>';
            });

            document.querySelector('#hit_mhs').innerHTML = options;
        })
    }

    function castvote(e, action = null) {
        var datalist = document.querySelector(`#${e.getAttribute('list')}`).children

        var flag = false
        for(let i = 0; i < datalist.length; i++){
            flag = datalist[i].value === e.value || flag
        }

        if (!flag) {
            if (action == null)
                e.value = ""
            
            return false
        } else {
            return true
        }
    }
</script>