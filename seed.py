from app import create_app, db
from app.models import AdminUser
from app.utils import hash_password

def seed_admin():
    app = create_app()
    
    # Ensure the app context is pushed correctly
    with app.app_context():
        # Ensure the database is properly initialized
        db.create_all()
        
        # Check if admin user already exists
        if not AdminUser.query.first():
            admin = AdminUser(username="admin", password_hash=hash_password("admin123"))
            db.session.add(admin)
            db.session.commit()
            print("✅ Admin user created successfully!")
        else:
            print("⚠️ Admin user already exists!")

if __name__ == "__main__":
    seed_admin()
