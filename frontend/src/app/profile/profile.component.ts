import {Component, OnDestroy, OnInit} from '@angular/core';
import {ActivatedRoute} from '@angular/router';
import {Observable} from 'rxjs';
import { debounceTime } from 'rxjs/operators';
import { FormGroup, FormControl } from '@angular/forms';
import {WebcamComponent} from '../webcam/webcam.component';

@Component({
  selector: 'app-profile',
  templateUrl: './profile.component.html',
  styleUrls: ['./profile.component.scss'],
})
export class ProfileComponent implements OnInit, OnDestroy {
  private routeSub;
  private onChangeSub;
  private onChangeObserver;

  public user;

  public chief = {
    full_name: 'Иванова Ира Ивановна',
    photo: 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRHYCXmvhBed3-UBNkFkTITn4OWQHafcKFCLQgeIdsImWWCPr_p',
  };

  public profileForm = new FormGroup({
    photo: new FormControl(),
    last_name: new FormControl(),
    first_name: new FormControl(),
    middle_name: new FormControl(),
    chief_id: new FormControl(),
  });
  public profileId;
  public saveStatusText;
  public profilePhotoUrl = 'https://colegioclassea.com.br/wp-content/themes/PageLand/assets/img/avatar/avatar.jpg';

  constructor(private route: ActivatedRoute) {}

  ngOnInit() {
    this.routeSub = this.route.params
        .subscribe((value) => {
          this.profileId = value.id;
        });

    this.onChangeSub = new Observable((observer) => {
      this.onChangeObserver = observer;
    });

    this.onChangeSub
        .pipe(debounceTime(3000))
        .subscribe(() => {
          this.saveFormData(this.profileForm.value);
        });

    this.getUser(null);
    this.profileForm.controls.last_name.setValue(this.user.last_name);
    this.profileForm.controls.first_name.setValue(this.user.first_name);
    this.profileForm.controls.middle_name.setValue(this.user.middle_name);
  }

  public saveFormData(formData) {
    this.saveStatusText = 'Сохраняется';
    setTimeout(() => {
      this.saveStatusText = 'Сохранено';
      this.getUser(formData);
    }, 1000);
  }

  private getUser(data) {
    if (data) {
      this.user = data;
    } else {
      this.user = {
        last_name: 'Иванов',
        first_name: 'Иван',
        middle_name: 'Иванович',
      };
    }
  }

  public onSubmit() {
    this.onChangeObserver.next();
  }

  public onCapture($event: string) {
    this.profilePhotoUrl = $event;
  }

  public ngOnDestroy(): void {
    this.routeSub.unsubscbibe();
    if (this.onChangeSub) {
      this.onChangeSub.unsubscribe();
    }
  }
}
