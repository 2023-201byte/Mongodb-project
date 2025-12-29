const express = require("express");
const mongoose = require("mongoose");

const app = express();
app.use(express.json());
app.use(express.urlencoded({ extended: true }));

mongoose.connect("mongodb://127.0.0.1:27017/crime_reporting_db")
.then(()=>console.log("MongoDB Connected"));

const Anonymous = mongoose.model("Anonymous", {
  crime_type:String,
  city:String,
  description:String,
  evidence:String
});

const FIR = mongoose.model("FIR", {
  full_name:String,
  cnic:String,
  phone:String,
  city:String,
  place:String,
  crime_type:String,
  description:String,
  evidence:String
});

const Request = mongoose.model("Request", {
  cnic:String,
  fir_copy:String
});

const Women = mongoose.model("Women", {
  full_name:String,
  cnic:String,
  phone:String,
  city:String,
  issue_type:String,
  description:String,
  evidence:String
});

app.post("/anonymous", async(req,res)=>{
  await Anonymous.create(req.body);
  res.send("Saved");
});

app.post("/fir", async(req,res)=>{
  await FIR.create(req.body);
  res.send("Saved");
});

app.post("/request", async(req,res)=>{
  await Request.create(req.body);
  res.send("Saved");
});

app.post("/women", async(req,res)=>{
  await Women.create(req.body);
  res.send("Saved");
});

app.listen(3000,()=>console.log("Server running on port 3000"));
