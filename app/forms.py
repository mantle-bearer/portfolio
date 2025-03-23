from flask_wtf import FlaskForm
from wtforms import StringField, PasswordField, TextAreaField, SubmitField
from wtforms.validators import DataRequired, Length, Email

class LoginForm(FlaskForm):
    username = StringField("Username", validators=[DataRequired(), Length(min=4, max=20)])
    password = PasswordField("Password", validators=[DataRequired()])
    submit = SubmitField("Login")

class HomeForm(FlaskForm):
    title = StringField("Title", validators=[DataRequired()])
    subtitle = StringField("Subtitle")
    cv_url = StringField("CV URL")
    submit = SubmitField("Update Home Page")

class AboutMeForm(FlaskForm):
    description = TextAreaField("Description", validators=[DataRequired()])
    experience_years = StringField("Experience (Years)")
    clients = StringField("Clients")
    working_hours = StringField("Working Hours")
    awards = StringField("Awards Won")
    submit = SubmitField("Update About Page")