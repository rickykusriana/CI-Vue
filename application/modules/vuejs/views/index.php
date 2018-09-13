<!-- <script src="<?=base_url();?>src/vendor/require.min.js" data-main="src/require.config"></script> -->

<section id="app">
	<header class="header">
		<h1>todos</h1>
		<input class="new-todo"
		autofocus autocomplete="off"
		placeholder="What needs to be done?"
		v-model="newTodo"
		@keyup.enter="addTodo">
	</header>

	<section class="main" v-show="todos.length" v-cloak>
		<input class="toggle-all" type="checkbox" v-model="allDone">
		<ul class="todo-list">
		<li v-for="todo in filteredTodos"
		class="todo"
		:key="todo.id"
		:class="{ completed: todo.completed, editing: todo == editedTodo }">
		<div class="view">
		<input class="toggle" type="checkbox" v-model="todo.completed">
		<label @dblclick="editTodo(todo)">{{ todo.title }}</label>
		<button class="destroy" @click="removeTodo(todo)"></button>
		</div>
		<input class="edit" type="text"
		v-model="todo.title"
		v-todo-focus="todo == editedTodo"
		@blur="doneEdit(todo)"
		@keyup.enter="doneEdit(todo)"
		@keyup.esc="cancelEdit(todo)">
		</li>
		</ul>
	</section>
	
	<footer class="footer" v-show="todos.length" v-cloak>
		<span class="todo-count">
		<strong>{{ remaining }}</strong> {{ remaining | pluralize }} left
		</span>
		<ul class="filters">
		<li><a href="#/all" :class="{ selected: visibility == 'all' }">All</a></li>
		<li><a href="#/active" :class="{ selected: visibility == 'active' }">Active</a></li>
		<li><a href="#/completed" :class="{ selected: visibility == 'completed' }">Completed</a></li>
		</ul>
		<button class="clear-completed" @click="removeCompleted" v-show="todos.length > remaining">
		Clear completed
		</button>
	</footer>

</section>

<script src="<?=base_url();?>src/vendor/vue.js"></script>
<script src="<?=base_url();?>src/vendor/vue-router.js"></script>
<script src="<?=base_url();?>src/vendor/axios.min.js"></script>
<script src="<?=base_url();?>src/app-todo.js"></script>