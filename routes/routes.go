package routes

import (
	"database/sql"
	"net/http"

	"github.com/segaak/erpbl/controller"
)

func MapRoutes(server *http.ServeMux, db *sql.DB) {
	server.HandleFunc("/", controller.DashboardHandler(db))
	server.HandleFunc("/product", controller.ProductHandler(db))
}
