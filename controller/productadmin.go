package controller

import (
	"database/sql"
	"html/template"
	"net/http"
)

func ProductHandler(db *sql.DB) func(http.ResponseWriter, *http.Request) {
	return func(w http.ResponseWriter, r *http.Request) {
		tmpl, err := template.ParseFiles(
			"views/admin/product.html",
			"parts/admin/navbar.html",
			"parts/admin/sidebar.html",
		)
		if err != nil {
			http.Error(w, err.Error(), http.StatusInternalServerError)
			return
		}

		err = tmpl.ExecuteTemplate(w, "product", map[string]interface{}{
			"CurrentPath": r.URL.Path,
		})
	}
}
