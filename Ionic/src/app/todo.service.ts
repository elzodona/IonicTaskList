import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { Observable } from 'rxjs';

@Injectable({
  providedIn: 'root'
})

export class TodoService {

  id: any;
  user: any;
  token: any

  constructor(private breukh: HttpClient) {
    const use = localStorage.getItem('user');
    this.user = JSON.parse(use!);
    this.id = this.user.id;

    const toke = localStorage.getItem('token');
    this.token = JSON.parse(toke!);

  }

  addTask(data: any): Observable<any> {
    const httpOptions = {
      headers: new HttpHeaders({
        'Content-Type': 'application/json',
        'Authorization': `Bearer ${this.token}`
      }),
    };
    return this.breukh.post(`http://127.0.0.1:8000/api/task/create/${this.id}`, data, httpOptions);
  }

  allTask() {
    const httpOptions = {
      headers: new HttpHeaders({
        'Content-Type': 'application/json',
        'Authorization': `Bearer ${this.token}`
      }),
    };
    return this.breukh.get(`http://127.0.0.1:8000/api/task/list/${this.id}`, httpOptions)
  }

  deleteTask(id: number) {
    const httpOptions = {
      headers: new HttpHeaders({
        'Content-Type': 'application/json',
        'Authorization': `Bearer ${this.token}`
      }),
    };
    return this.breukh.delete(`http://127.0.0.1:8000/api/task/delete/2/${id}`, httpOptions)
  }

  updateTask(data: any): Observable<any> {
    const httpOptions = {
      headers: new HttpHeaders({
        'Content-Type': 'application/json',
        'Authorization': `Bearer ${this.token}`
      }),
    };
    return this.breukh.post(`http://127.0.0.1:8000/api/task/update/${this.id}`,data, httpOptions);
  }

  searchTask(name: string){
    const httpOptions = {
      headers: new HttpHeaders({
        'Content-Type': 'application/json',
        'Authorization': `Bearer ${this.token}`
      }),
    };
    return this.breukh.post(`http://127.0.0.1:8000/api/task/search/${this.id}`, { taskName: name }, httpOptions);
  }


}

