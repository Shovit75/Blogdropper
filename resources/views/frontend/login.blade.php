@extends('frontend.partials.body')
@section('body')

<section class="background">
    <div class="container py-5">
      <div class="row d-flex justify-content-center align-items-center" data-aos="slide-up">
        <div class="col col-xl-10">
          <div class="card" style="border-radius: 1rem;">
            <div class="row g-0">
              <div class="col-md-6 col-lg-5 d-none d-md-block">
                <img src="{{ asset('frontend_assets/assets/img/login.jpg') }}"
                  alt="login" class="img-fluid" style="border-radius: 1rem 0 0 1rem;" />
              </div>
              <div class="col-md-6 col-lg-7 d-flex align-items-center">
                <div class="card-body p-4 p-lg-5 text-black">

                  <form action="{{route('frontend.weblogin')}}" method="POST">
                    @csrf
                    <div class="d-flex align-items-center mb-3 pb-1">
                      <span class="h1 fw-bold mb-0">BlogDropper</span>
                    </div>

                    <h5 class="fw-normal mb-3 pb-3" style="letter-spacing: 1px;">Sign into your account</h5>

                    <div class="form-outline mb-4">
                        <span class="text-danger">
                            @error('email')
                                {{$message}}
                            @enderror
                        </span>
                      <input name="email" type="email" id="email" class="form-control form-control-lg" />
                      <label class="form-label" for="email">Email address</label>
                    </div>

                    <div class="form-outline mb-3">
                        <span class="text-danger">
                            @error('password')
                                {{$message}}
                            @enderror
                        </span>
                      <input name="password" type="password" id="password" class="form-control form-control-lg" />
                      <label class="form-label" for="password">Password</label>
                    </div>

                    <div class="pt-1 mb-4">
                      <button class="btn btn-dark btn-lg btn-block" type="submit">Login</button>
                    </div>

                  </form>

                <hr>
                  <p>
                    <a href="{{ route('google-auth') }}">
                        <button class="btn btn-secondary btn-lg">
                            <i class="fab fa-google fa-fw"></i>
                            Continue with Google
                        </button>
                    </a>
                  </p>
                    <p class="mb-2 pb-lg-2">Don't have an account? <a href="{{ route('frontend.signup') }}" style="color: #393f81;">Register Manually</a></p>
                
                    {{-- <a class="small text-muted" href="#!">Forgot password?</a> --}}
                    
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

@endsection
