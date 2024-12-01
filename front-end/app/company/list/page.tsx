"use client"; // クライアントコンポーネントとして明示

import { useEffect, useState } from "react";
import {
  Table,
  TableBody,
  TableCell,
  TableContainer,
  TableHead,
  TableRow,
  Paper,
  Typography,
} from "@mui/material";

type CompanyData = {
  company_name: string;
  stock_code: string;
  announcement_date: string;
  revenue: string;
  profit: string;
};

const Companies = () => {
  const [data, setCompanyData] = useState<CompanyData[]>([]);

  useEffect(() => {
    const fetchCompanyData = async () => {
      try {
        const response = await fetch("/data.json");
        const jsonData: CompanyData[] = await response.json();
        setCompanyData(jsonData);
      } catch (error) {
        console.error("データ取得に失敗しました", error);
      }
    };

    fetchCompanyData();
  }, []);

  return (
    <div style={{ padding: "20px" }}>
      <Typography variant="h4" gutterBottom>
        上場企業の決算発表データ
      </Typography>
      <TableContainer component={Paper} style={{ marginTop: "20px" }}>
        {/* Material-UIのTableコンポーネント */}
        <Table>
          {/* ヘッダー */}
          <TableHead>
            <TableRow>
              {/* 各列のヘッダーセルをTableCellで定義 */}
              <TableCell><strong>会社名</strong></TableCell>
              <TableCell><strong>証券コード</strong></TableCell>
              <TableCell><strong>発表日</strong></TableCell>
              <TableCell><strong>売上高</strong></TableCell>
              <TableCell><strong>利益</strong></TableCell>
            </TableRow>
          </TableHead>
          {/* ボディ */}
          <TableBody>
            {/* 各会社のデータをTableRow行としてレンダリング */}
            {data.map((company, index) => (
              <TableRow key={index}>
                <TableCell>{company.company_name}</TableCell>
                <TableCell>{company.stock_code}</TableCell>
                <TableCell>{company.announcement_date}</TableCell>
                <TableCell>{company.revenue}</TableCell>
                <TableCell>{company.profit}</TableCell>
              </TableRow>
            ))}
          </TableBody>
        </Table>
      </TableContainer>
    </div>
  );
};

// 他のファイルで利用できるようにエクスポート
export default Companies;
