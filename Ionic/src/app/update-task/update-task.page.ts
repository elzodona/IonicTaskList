import { Component, Input, OnInit } from '@angular/core';
import { TodoService } from '../todo.service';
import { ModalController } from '@ionic/angular';

@Component({
  selector: 'app-update-task',
  templateUrl: './update-task.page.html',
  styleUrls: ['./update-task.page.scss'],
})
export class UpdateTaskPage implements OnInit {
  @Input() task!: any;
  categoris= ['work','personnal','fun']
  taskName: any;
  taskDate: any;
  taskPriority: any;
  taskCategory: any;
  id!: number

  constructor(public modalcontrol:ModalController,public todoservice:TodoService) { }

  ngOnInit() {
    this.id=this.task.id;
    // this.taskName=this.task.taskName
    // this.taskDate=this.task.taskDate
    // this.taskPriority=this.task.priority
    // this.taskCategory=this.task.category
  }

  async dismis(){
    await this.modalcontrol.dismiss()
  }

  selectCategoris(index:number){
    this.taskCategory=this.categoris[index]
  }

  formatDate(inputDate: any) {
    const dateObject = new Date(inputDate);

    const day = dateObject.getDate();
    const month = dateObject.getMonth() + 1;
    const year = dateObject.getFullYear();

    const formattedDate = `${day < 10 ? '0' : ''}${day}/${month < 10 ? '0' : ''}${month}/${year}`;

    return formattedDate;
  }

  async update(){
    const taskData = {
      id: this.id,
      taskName: this.taskName,
      taskDate: this.formatDate(this.taskDate),
      priority: this.taskPriority,
      category: this.taskCategory,
    };
    // console.log(taskData);

    this.todoservice.updateTask(taskData).subscribe((res: any) => {
      console.log(res);
    });
  }

}
