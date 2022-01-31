export class Invitation {
  id: number;
  comment: string;
  status: string;
  sender: number;
  senderName: string;
  guest: number;
  guestName: string;

  constructor(  id: number, comment: string, status: string, sender: number, senderName: string, guest: number, guestName: string) {
    this.id = id;
    this.comment = comment;
    this.status = status;
    this.sender = sender;
    this.senderName = senderName;
    this.guest = guest;
    this.guestName = guestName;
  }

}
