from flask import Flask, render_template, redirect, url_for, request, flash
from flask_login import LoginManager, login_user, login_required, logout_user, current_user, UserMixin
from werkzeug.security import generate_password_hash, check_password_hash
from forms import LoginForm, RegisterForm, NoteForm
import markdown

app = Flask(__name__)
app.config['SECRET_KEY'] = 'change-this-secret-key'
app.config['SQLALCHEMY_DATABASE_URI'] = 'sqlite:///database.db'
app.config['SQLALCHEMY_TRACK_MODIFICATIONS'] = False

from models import db
db.init_app(app)
login_manager = LoginManager(app)
login_manager.login_view = 'login'

from models import User, Note  # noqa: E402

@login_manager.user_loader
def load_user(user_id):
    return User.query.get(int(user_id))

@app.route('/')
@login_required
def index():
    search = request.args.get('search', '')
    if search:
        notes = Note.query.filter(Note.user_id == current_user.id, Note.content.contains(search)).all()
    else:
        notes = Note.query.filter_by(user_id=current_user.id).all()
    form = NoteForm()
    return render_template('index.html', notes=notes, form=form, search=search)

@app.route('/add', methods=['POST'])
@login_required
def add_note():
    form = NoteForm()
    if form.validate_on_submit():
        html = markdown.markdown(form.content.data)
        note = Note(content=html, color=form.color.data, user_id=current_user.id)
        db.session.add(note)
        db.session.commit()
        flash('Note added')
    return redirect(url_for('index'))

@app.route('/delete/<int:note_id>')
@login_required
def delete_note(note_id):
    note = Note.query.get_or_404(note_id)
    if note.user_id != current_user.id:
        flash('Not authorized')
        return redirect(url_for('index'))
    db.session.delete(note)
    db.session.commit()
    flash('Note deleted')
    return redirect(url_for('index'))

@app.route('/login', methods=['GET', 'POST'])
def login():
    form = LoginForm()
    if form.validate_on_submit():
        user = User.query.filter_by(username=form.username.data).first()
        if user and check_password_hash(user.password, form.password.data):
            login_user(user)
            return redirect(url_for('index'))
        flash('Invalid credentials')
    return render_template('login.html', form=form)

@app.route('/register', methods=['GET', 'POST'])
def register():
    form = RegisterForm()
    if form.validate_on_submit():
        hash_pw = generate_password_hash(form.password.data)
        user = User(username=form.username.data, password=hash_pw)
        db.session.add(user)
        db.session.commit()
        flash('Account created, please log in')
        return redirect(url_for('login'))
    return render_template('register.html', form=form)

@app.route('/logout')
@login_required
def logout():
    logout_user()
    return redirect(url_for('login'))

if __name__ == '__main__':
    with app.app_context():
        db.create_all()
    app.run(debug=True)
