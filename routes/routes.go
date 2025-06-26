package routes

import (
	"database/sql"
	"net/http"

	"github.com/segaak/erpbl/controller"
)

func MapRoutes(server *http.ServeMux, db *sql.DB) {
	server.HandleFunc("/admindashboard", controller.DashboardHandler(db))
	server.HandleFunc("/product", controller.ProductHandler(db))
	server.HandleFunc("/order", controller.OrderHandler(db)) // GANTI DI SINI
	server.HandleFunc("/report", controller.ReportHandler(db))
	server.HandleFunc("/stock", controller.StockHandler(db))
	server.HandleFunc("/ownerdashboard", controller.OwnerDashboardHandler(db))
	server.HandleFunc("/ownerreport", controller.OwnerReportHandler(db))
	server.HandleFunc("/ownerproduct", controller.OwnerProductHandler(db))
	server.HandleFunc("/admin/tambahproduct", controller.TambahProductHandler(db))
	server.HandleFunc("/admin/editproduct", controller.EditProductHandler(db))
	server.HandleFunc("/updatestatus", controller.UpdateStatusHandler(db))
	server.HandleFunc("/admin/deleteproduct", controller.DeleteProductHandler(db))
	server.HandleFunc("/admin/saleschart", controller.SalesChartHandler(db))
}
