import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import {Observable} from "rxjs";

import { environment } from '../../environments/environment';
import {Invitation} from "../_models/invitation.model";

const httpOptions = {
  headers: new HttpHeaders({ 'Content-Type': 'application/json' })
};

@Injectable({
  providedIn: 'root'
})

export class InvitationsService {

  constructor(private http: HttpClient) { }

  getInvitations(): Observable<Invitation[]>{
    return this.http.get<Invitation[]>(`${environment.url_api}/invitation`);
  }

  sendInvitation(sender: number, guest: number, comment: string): Observable<any> {
    return this.http.post(`${environment.url_api}/invitation`, {
      'sender': sender,
      'guest': guest,
      'comment': comment
    }, httpOptions);
  }

  deleteInvitation(idInvitation: number): Observable<any> {
    return this.http.delete(`${environment.url_api}/invitation/`+idInvitation, httpOptions);
  }

  updateStatusInvitation(idInvitation: number, status: string): Observable<any> {
    return this.http.post(`${environment.url_api}/invitation/`+idInvitation, {'status': status}, httpOptions);
  }


}
