import { Component, OnInit } from '@angular/core';
import {NgbModal, ModalDismissReasons} from "@ng-bootstrap/ng-bootstrap";
import {first} from "rxjs"
  ;
import { InvitationsService } from "../_services/invitations.service";
import {Invitation} from "../_models/invitation.model";
import { TokenStorageService } from '../_services/token-storage.service';

@Component({
  selector: 'app-invitations',
  templateUrl: './invitations.component.html',
  styleUrls: ['./invitations.component.css']
})
export class InvitationsComponent implements OnInit {

  invitations: Invitation[] | undefined;
  errorMessage: string = '';

  sendForm: any = {
    guest: null,
    comment: null
  };
  isSuccessful = false;
  isSendFailed = false;


  constructor(
    private invitationsService: InvitationsService,
    private tokenStorageService: TokenStorageService,
    private modalService: NgbModal
  ) { }

  ngOnInit(): void {
    this.invitationsService.getInvitations().pipe(first()).subscribe({
      next: data => {
        this.invitations = data;
      },
      error: err => {
        this.errorMessage = err.error.message;
      }
    })
  }

  isTheSender (invitation: Invitation) {
    return invitation.sender == this.tokenStorageService.getUser().id;
  }

  isTheGuest (invitation: Invitation) {
    return invitation.guest == this.tokenStorageService.getUser().id;
  }

  openSendInvitationModal(content:any) {
    this.modalService.open(content, {ariaLabelledBy: 'modal-basic-title'});
  }

  sendInvitation(): void {
    const { guest, comment} = this.sendForm;

    this.invitationsService.sendInvitation(this.tokenStorageService.getUser().id, guest, comment).subscribe({
      next: data => {
        this.isSuccessful = true;
        this.isSendFailed = false;
      },
      error: err => {
        this.errorMessage = err.error.message;
        this.isSendFailed = true;
      }
    });
  }

  deleteInvitation(id: number) {
    this.invitationsService.deleteInvitation(id).subscribe({
      next: data => {
        window.location.reload();
      },
      error: err => {
        this.errorMessage = err.error.message;
      }
    });
  }

  updateStatusInvitation(id: number, status: string) {
    this.invitationsService.updateStatusInvitation(id, status).subscribe({
      next: data => {
        window.location.reload();
      },
      error: err => {
        this.errorMessage = err.error.message;
      }
    });
  }

  getClsByStatus(status: string) {
      let statusCls: {[key: string]: string} = {
      accepted : 'table-success',
      declined : 'table-warning',
      canceled : 'table-danger'
    }
    console.log(statusCls[status]);
    return statusCls[status];
  }
}
