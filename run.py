from flask import Flask
from flask_migrate import Migrate
from flask_login import LoginManager
from app.models.models import db, AdminUser
from app.routes import main
from app.admin_routes import admin
from app.config import Config

app = Flask(__name__)
app.config.from_object(Config)

db.init_app(app)
migrate = Migrate(app, db)

login_manager = LoginManager()
login_manager.init_app(app)
login_manager.login_view = "admin.login"

@login_manager.user_loader
def load_user(user_id):
    return AdminUser.query.get(int(user_id))

app.register_blueprint(main)
app.register_blueprint(admin)

if __name__ == "__main__":
    app.run(debug=True)
