package controller

import (
	"database/sql"
	"encoding/json"
	"fmt"
	"html/template"
	"net/http"
	"time"
)

type ProductSales struct {
	NamaProduk   string `json:"nama_produk"`
	TotalTerjual int    `json:"total_terjual"`
}

type ProductDetail struct {
	NamaProduk string
	Kategori   string
	Harga      float64
	Stok       int
	Gambar     string
	Satuan     string
}

func OwnerProductHandler(db *sql.DB) http.HandlerFunc {
	return func(w http.ResponseWriter, r *http.Request) {
		funcMap := template.FuncMap{
			"toJson": func(v interface{}) template.JS {
				b, _ := json.Marshal(v)
				return template.JS(b)
			},
		}

		tmpl := template.Must(template.New("ownerproduct.html").Funcs(funcMap).ParseFiles(
			"views/owner/ownerproduct.html",
			"parts/owner/navbar.html",
			"parts/owner/sidebar.html",
		))

		month := r.URL.Query().Get("month")
		if month == "" {
			month = fmt.Sprintf("%02d", time.Now().Month())
		}

		rows, err := db.Query(`
			SELECT p.nama_produk, SUM(ps.jumlah) as total_terjual
			FROM pesanan ps
			JOIN produk p ON ps.id_produk = p.ID_Produk
			JOIN pembayaran pm ON ps.id_pembayaran = pm.id
			WHERE MONTH(pm.tanggal) = ?
			GROUP BY p.nama_produk
			ORDER BY total_terjual DESC
		`, month)
		if err != nil {
			http.Error(w, err.Error(), http.StatusInternalServerError)
			return
		}
		defer rows.Close()

		var sales []ProductSales
		for rows.Next() {
			var ps ProductSales
			if err := rows.Scan(&ps.NamaProduk, &ps.TotalTerjual); err == nil {
				sales = append(sales, ps)
			}
		}

		detailRows, err := db.Query(`SELECT nama_produk, kategori, harga, stok, gambar, satuan FROM produk`)
		if err != nil {
			http.Error(w, err.Error(), http.StatusInternalServerError)
			return
		}
		defer detailRows.Close()

		var products []ProductDetail
		for detailRows.Next() {
			var pd ProductDetail
			if err := detailRows.Scan(&pd.NamaProduk, &pd.Kategori, &pd.Harga, &pd.Stok, &pd.Gambar, &pd.Satuan); err == nil {
				products = append(products, pd)
			}
		}

		data := map[string]interface{}{
			"SalesData":     sales,
			"ProductList":   products,
			"SelectedMonth": month,
		}

		tmpl.ExecuteTemplate(w, "ownerproduct", data)
	}
}
