from flask import Blueprint, render_template, redirect, url_for, flash
from flask_login import login_user, logout_user, login_required
from app.forms import LoginForm, HomeForm, AboutMeForm
from app.models.models import AdminUser, HomeContent, AboutMe, db
from app.utils import hash_password, check_password

admin = Blueprint("admin", __name__)

@admin.route("/admin/login", methods=["GET", "POST"])
def login():
    form = LoginForm()
    if form.validate_on_submit():
        user = AdminUser.query.filter_by(username=form.username.data).first()
        if user and check_password(user.password_hash, form.password.data):
            login_user(user)
            return redirect(url_for("admin.dashboard"))
        flash("Invalid credentials", "danger")
    return render_template("admin/login.html", form=form)

@admin.route("/admin/dashboard")
@login_required
def dashboard():
    return render_template("admin/dashboard.html")

@admin.route("/admin/home", methods=["GET", "POST"])
@login_required
def edit_home():
    content = HomeContent.query.first()
    form = HomeForm(obj=content)
    if form.validate_on_submit():
        content.title = form.title.data
        content.subtitle = form.subtitle.data
        content.cv_url = form.cv_url.data
        db.session.commit()
        flash("Home page updated!", "success")
        return redirect(url_for("admin.dashboard"))
    return render_template("admin/edit_home.html", form=form)

@admin.route("/admin/about", methods=["GET", "POST"])
@login_required
def edit_about():
    about = AboutMe.query.first()
    form = AboutMeForm(obj=about)
    if form.validate_on_submit():
        about.description = form.description.data
        about.experience_years = form.experience_years.data
        about.clients = form.clients.data
        about.working_hours = form.working_hours.data
        about.awards = form.awards.data
        db.session.commit()
        flash("About Me updated!", "success")
        return redirect(url_for("admin.dashboard"))
    return render_template("admin/edit_about.html", form=form)

@admin.route("/admin/logout")
@login_required
def logout():
    logout_user()
    return redirect(url_for("admin.login"))
