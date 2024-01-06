import { ComponentFixture, TestBed } from '@angular/core/testing';
import { AjouTaskPage } from './ajou-task.page';

describe('AjouTaskPage', () => {
  let component: AjouTaskPage;
  let fixture: ComponentFixture<AjouTaskPage>;

  beforeEach(async(() => {
    fixture = TestBed.createComponent(AjouTaskPage);
    component = fixture.componentInstance;
    fixture.detectChanges();
  }));

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
