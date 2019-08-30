import {ChangeDetectorRef, Component, EventEmitter, OnInit, Output} from '@angular/core';

@Component({
  selector: 'app-webcam',
  templateUrl: './webcam.component.html',
  styleUrls: ['./webcam.component.scss']
})
export class WebcamComponent implements OnInit {
  @Output()
  public captureEvent = new EventEmitter<string>();

  public errorText = '';
  public captureContent = '';
  public isHideTurnOnCamButton = false;
  public isHideCanvas = true;
  public isHideCaptureButton = true;
  public isHideImg = true;
  public isHideVideo = true;
  private video;
  private img;
  private canvas;
  private ctx;
  private stream;

  constructor(private ref: ChangeDetectorRef) {}

  ngOnInit() {
    this.video = document.getElementById('webcam__video');
    this.img = document.getElementById('webcam__img');
    this.canvas = document.getElementById('webcam__canvas');
    this.ctx = this.canvas.getContext('2d');
  }

  public onTurnOnCam() {
    if ( ! navigator.getUserMedia) {
      this.errorText = 'К сожалению метод: navigator.getUserMedia() недоступен.';
      return;
    }

    navigator.getUserMedia({video: true}, this.gotStream.bind(this), this.noStream.bind(this));
  }

  public gotStream(stream) {
    this.stream = stream;

    if (this.video.srcObject === undefined) {
      this.video.src = window.URL.createObjectURL(stream);
    } else {
      this.video.srcObject  = stream;
    }

    this.video.onerror = (e) => {
      this.stream.stop();
    };

    this.video.onloadedmetadata = (e) => {
      this.canvas.width = this.video.videoWidth;
      this.canvas.height = this.video.videoHeight;
    };

    this.onTurnOnCamManipulations();
    this.ref.detectChanges();
  }

  public noStream(e) {
    this.errorText = (e.code === 1) ? 'Нет доступа к камере.' : 'Камера не подключена.';
    this.onCaptureManipulations();
    this.ref.detectChanges();
  }

  public onCapture() {
    this.ctx.drawImage(this.video, 0, 0);
    this.captureContent = this.canvas.toDataURL('image/webp');
    this.img.width = this.canvas.width;
    this.img.height = this.canvas.height;
    if (this.stream) {
      this.stream.getTracks()[0].stop();
    }

    this.onCaptureManipulations();
    this.ref.detectChanges();
    this.captureEvent.emit(this.captureContent);
  }

  private onCaptureManipulations() {
    this.isHideCaptureButton = true;
    this.isHideTurnOnCamButton = false;
    this.isHideVideo = true;
    this.isHideImg = false;
  }

  private onTurnOnCamManipulations() {
    this.isHideCaptureButton = false;
    this.isHideVideo = false;
    this.isHideImg = true;
    this.isHideTurnOnCamButton = true;
  }

}
