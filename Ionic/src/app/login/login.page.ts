import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { Router } from '@angular/router';
import { AuthService } from '../auth.service';


@Component({
  selector: 'app-login',
  templateUrl: './login.page.html',
  styleUrls: ['./login.page.scss'],
})
export class LoginPage implements OnInit {

  loginForm!: FormGroup;

  constructor(private fb: FormBuilder, private router: Router, private authService: AuthService) {
    this.loginForm = this.fb.group({
      email: ['ndaoelhadji973@gmail.com', [Validators.required, Validators.email]],
      password: ['elzondao', Validators.required]
    });
  }

  ngOnInit() {
  }

  onSubmit() {
    // console.log(this.loginForm.value);
    this.authService.login(this.loginForm.value).subscribe(
      (response: any) => {
        console.log(response);
        this.router.navigate(['/home']);
        localStorage.setItem('user', JSON.stringify(response.user));
        localStorage.setItem('token', JSON.stringify(response.token));
      },
      (error) => {
        console.error('Erreur de connexion :', error);
        this.router.navigate(['']);
      }
    );
  }

  register()
  {
    this.router.navigate(['/register']);
  }



}
