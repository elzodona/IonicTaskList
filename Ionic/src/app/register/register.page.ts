import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { Router } from '@angular/router';
import { AuthService } from '../auth.service';


@Component({
  selector: 'app-register',
  templateUrl: './register.page.html',
  styleUrls: ['./register.page.scss'],
})
export class RegisterPage implements OnInit {

  loginForm!: FormGroup;

  constructor(private fb: FormBuilder, private router: Router, private authService: AuthService) {
    this.loginForm = this.fb.group({
      name: ['', Validators.required],
      email: ['', [Validators.required, Validators.email]],
      password: ['', Validators.required]
    });
  }

  ngOnInit() {
  }

  onSubmit() {
    // console.log(this.loginForm.value);
    this.authService.register(this.loginForm.value).subscribe(
      (response: any) => {
        console.log(response);
        this.router.navigate(['/login']);
      },
      (error) => {
        console.error('Erreur de connexion :', error);
        this.router.navigate(['/register']);
      }
    );
  }

  login() {
    this.router.navigate(['/login']);
  }


}
