package controller

import (
	"database/sql"
	"html/template"
	"net/http"
)

// StockAdminHandler handles the stock management page
func StockHandler(db *sql.DB) http.HandlerFunc {
	return func(w http.ResponseWriter, r *http.Request) {
		tmpl, err := template.ParseFiles(
			"views/admin/stock.html",
			"parts/admin/navbar.html",
			"parts/admin/sidebar.html",
		)
		if err != nil {
			http.Error(w, err.Error(), http.StatusInternalServerError)
			return
		}

		err = tmpl.ExecuteTemplate(w, "stock", map[string]interface{}{
			"CurrentPath": r.URL.Path,
		})
	}
}
