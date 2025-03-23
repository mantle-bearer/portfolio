from app.models.models import AdminUser, HomeContent, AboutMe, Service, PortfolioItem, ContactMessage, BlogPost


# Import the database instance
from app import db

# Ensure all models are known to Alembic for migrations
__all__ = ["AdminUser", "HomeContent", "AboutMe", "Service", "PortfolioItem", "BlogPost", "ContactMessage"]
