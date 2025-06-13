package controller

import (
	"database/sql"
	"html/template"
	"net/http"
)

// StockAdminHandler handles the stock management page
func OwnerProductHandler(db *sql.DB) http.HandlerFunc {
	return func(w http.ResponseWriter, r *http.Request) {
		tmpl, err := template.ParseFiles(
			"views/owner/ownerproduct.html",
			"parts/owner/navbar.html",
			"parts/owner/sidebar.html",
		)
		if err != nil {
			http.Error(w, err.Error(), http.StatusInternalServerError)
			return
		}

		err = tmpl.ExecuteTemplate(w, "ownerproduct", map[string]interface{}{
			"CurrentPath": r.URL.Path,
		})
	}
}
