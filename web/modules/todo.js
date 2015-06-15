angular.module('todoApp', ['ngRoute'])
  .controller('TodoListController', function(){
    var _this = this;

    /**
     * the main list
     * @type {{text: string, done: boolean}[]}
     */
    _this.todos = [
      {text:'learn angular', done:true},
      {text:'build an angular app', done:false}];

    /**
     * creates a new list item
     */
    _this.addTodo = function(){
      _this.todos.push({text:_this.todoText, done:false});
      _this.todoText='';
    };

    /**
     * counts the number of todo items with the done flag
     * @returns {number}
     */
    _this.remaining = function(){
      var count=0;
      angular.forEach(_this.todos, function(todo){
        count += (todo.done)?0:1;
      });
      return count;
    };

    /**
     * removes done items from the list
     */
    _this.archive = function(){
      var oldTodos = _this.todos;
      _this.todos = [];

      angular.forEach(oldTodos, function(todo){
        if(!todo.done) _this.todos.push(todo);
      })
    }
  });