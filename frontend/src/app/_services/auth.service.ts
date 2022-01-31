import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Observable } from 'rxjs';

const AUTH_API = 'http://localhost:8001/api/';

const httpOptions = {
  headers: new HttpHeaders({ 'Content-Type': 'application/json' })
};

@Injectable({
  providedIn: 'root'
})

export class AuthService {
  constructor(private http: HttpClient) { }

  login(email: string, password: string): Observable<any> {
    return this.http.post(AUTH_API + 'login', {
      'username': email,
      'password': password
    }, httpOptions);
  }

  register(name: string, email: string, password: string): Observable<any> {
    return this.http.post(AUTH_API + 'register', {
      'name': name,
      'email': email,
      'password': password
    }, httpOptions);
  }
}
