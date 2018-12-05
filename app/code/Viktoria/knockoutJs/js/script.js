(function (ko) {
    //хранит в себе методы которые работают и интерфейсом  (привязывается к дом елементам) и передает какието основные команды модели Chacklist
    var ChecklistViewModel = function (checklist) {
        var self = this;
        this.checklist = checklist;
        this.newTaskTitle = ko.observable('');

        // следим за изтенениес массива this.tasks (модели Chacklist)
        this.tasks = ko.observableArray();
        this.completeTasks = ko.observableArray();

        //здесь мы получаем данные с фронтенла и передаем их в модель Chacklist и все
        this.addTask = function () {
            // передаем значение которое ввели в инпуте за корорым следит observable
            this.checklist.addTask(this.newTaskTitle());

            // очищаем инпут
            this.newTaskTitle('');
// теперь все изменения в this.tasks = []; будут отображатся в this.tasks = ko.observableArray();
            this.tasks(this.checklist.tasks);
        };

        this.removeTask = function (taskObject, event) {
            self.checklist.removeTask(taskObject.id);
            self.tasks(self.checklist.tasks);
        };

        this.checkTask = function (taskObject, event) {
            self.checklist.checkTask(taskObject.id);
            self.tasks(self.checklist.tasks);
            self.completeTasks(self.checklist.completeTasks);
        };

        this.undoTask = function (taskObject, event) {
            self.checklist.undoTask(taskObject.id);
            self.tasks(self.checklist.tasks);
            self.completeTasks(self.checklist.completeTasks);
        };
    };

//модель- работает с данными. Добавляет данные, удаляет, сохраняет в бд и т.д.
    var Chacklist = function () {
        this.tasks = [];
        this.completeTasks = [];

        //сюда дается только название таска, сдесь мы его сохраняем в массив и отправляем на сервер.базу
        this.addTask = function (taskTitle) {
            //db operation
            //ajax reguests

            this.tasks.push({
                id: this.tasks.length,
                title: taskTitle
            });
            console.log(this.tasks);
        };

        this.removeTask = function (id) {
            var taskIndex = this.getIndexById(id, this.tasks);
            if (typeof taskIndex !== 'undefined') {
                this.tasks.splice(taskIndex, 1)
            }
        };
        this.checkTask = function (id) {
            var taskIndex = this.getIndexById(id, this.tasks),
            task;
            if (typeof taskIndex !== 'undefined') {
                task = this.tasks[taskIndex];
                this.tasks.splice(taskIndex, 1);
                this.completeTasks.push(task);
            }
        };
        this.undoTask = function (id) {
            var taskIndex = this.getIndexById(id, this.completeTasks),
                task;
            if (typeof taskIndex !== 'undefined') {
                task = this.completeTasks[taskIndex];
                this.completeTasks.splice(taskIndex, 1);
                this.tasks.push(task);
            }
        };

        this.getIndexById = function (id, tasks) {
            var index;
            for (var i = 0, max = tasks.length; i < max; i++) {
                if (tasks[i].id === id) {
                    index = i;
                    break;
                }
            }
            return index;
        };

    };

//ссылка на модель Chacklist которую передаем в ChecklistViewModel
    var checklist = new Chacklist();

//сразу указываем к какому елементу дом дерева мы хотим привязать ChecklistViewModel
    ko.applyBindings(new ChecklistViewModel(checklist), document.getElementById('todoList'));

})(ko);